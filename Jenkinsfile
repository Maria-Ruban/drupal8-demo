node('master') {
  currentBuild.result = "SUCCESS"
  try {
    notifyStarted();
    stage('Build') {
      checkout scm
      sh 'composer install && ./vendor/bin/phing'
    }

    // Deploy the code to the development environment.
    stage('Deploy to Dev') {
      // Run the ansible-playbook from the Jenkins master server to login and deploy to the development environment.
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-dev', returnStdout: true)
      println stdout
    }
    // Build code and generate quality reports.
    stage('Build in Dev') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/build-in-dev', returnStdout: true)
      println stdout
      // E-mail team that the deployment and build was successfull
      mail body: "Project build successful\n\r Build number : ${env.BUILD_NUMBER}\n\r Build URL : ${env.BUILD_URL}",
           from: 'prashanth@infanion',
           replyTo: 'prashanth@infanion.com',
           subject: 'Drupal 8 build successful',
           to: 'i-guide@infanion.com'

    }
    
    stage('Deploy to test') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-test', returnStdout: true)
      println stdout
    }

    stage('Test in test') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/test-deploy-in-test', returnStdout: true)
      println stdout
    }

    def userInput
    stage('Approve deploy to uat') {
      try {
        approveUatDeployment()
        userInput = input(
          id: 'approve-deploy-to-uat', message: 'Approve deploy to uat env?', parameters: [
            [$class: 'BooleanParameterDefinition', defaultValue: true, description: 'Promotion to uat.', name: 'I agree to deploy to uat.']
          ])
      } catch(err) { // input false
          def user = err.getCauses()[0].getUser()
          userInput = false
          echo "Aborted by: [${user}]"
          notifyFailed()
      }
    }
    if (userInput == true) {
      stage('Deploy to uat') {
        def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-uat', returnStdout: true)
        println stdout
      }
    } else {
      echo "Did not receive approval."
      currentBuild.result = 'FAILURE'
    } 

    stage('Test in uat') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/test-deploy-in-uat', returnStdout: true)
      println stdout
    }
    notifySuccessful();      
  } catch(err) {
    echo "Exception occured"
    currentBuild.result = "FAILURE"
    notifyFailed()
    mail body: "Project build failure is here: ${env.BUILD_URL}" ,
         from: 'prashanth@infanion',
         replyTo: 'prashanth@infanion.com',
         subject: 'Drupal 8 build failed',
         to: 'i-guide@infanion.com'
    throw err
  }
}

def approveUatDeployment() {
  mail to: 'i-guide@infanion.com',
  subject: "Job '${JOB_NAME}' (${BUILD_NUMBER}) is waiting for input",
  body: "Please go to ${BUILD_URL} and verify the build"

  slackSend (color: '#FFF000', message: "Waiting for approval: Job '${env.JOB_NAME} [${env.BUILD_NUMBER}]' (${env.JOB_URL}/${env.BUILD_NUMBER}/input)")
}

def notifyStarted() {
  slackSend (color: '#FFFF00', message: "STARTED: Job '${env.JOB_NAME} [${env.BUILD_NUMBER}]' (${env.BUILD_URL})")
}

def notifySuccessful() {
  slackSend (color: '#00FF00', message: "SUCCESSFUL: Job '${env.JOB_NAME} [${env.BUILD_NUMBER}]' (${env.BUILD_URL})")
}

def notifyFailed() {
  slackSend (color: '#FF0000', message: "FAILED: Job '${env.JOB_NAME} [${env.BUILD_NUMBER}]' (${env.BUILD_URL})")
}
