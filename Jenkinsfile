node('master') {
  currentBuild.result = "SUCCESS"
  try {
    // Deploy the code to the development environment.
    stage('Deploy to Dev') {
      // Run the ansible-playbook from the Jenkins master server to login and deploy to the development environment.
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-dev', returnStdout: true)
      println stdout
      // E-mail team that the deployment was successfull
      mail body: "Project deployed successful\n\r Build number : ${env.BUILD_NUMBER}\n\r Build URL : ${env.BUILD_URL}",
           from: 'prashanth@infanion',
           replyTo: 'prashanth@infanion.com',
           subject: 'Drupal 8 build successful',
           to: 'i-guide@infanion.com'
    }
    // Build code and generate quality reports.
    stage('Build in Dev') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/build-in-dev', returnStdout: true)
      println stdout
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
    stage('Approve deploy to staging') {
      try {
        userInput = input(
          id: 'approve-deploy-to-staging', message: 'Approve deploy to staging env?', parameters: [
            [$class: 'BooleanParameterDefinition', defaultValue: true, description: 'Promotion to staging.', name: 'I agree to deploy to staging.']
          ])
      } catch(err) { // input false
          def user = err.getCauses()[0].getUser()
          userInput = false
          echo "Aborted by: [${user}]"
      }
    }
    if (userInput == true) {
      stage('Deploy to staging') {
        waitUntil {
          try {
            def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-staging', returnStdout: true)
            println stdout
          } catch(error) {
             input "Retry the job ?"
             false
          }
        }
      }

      stage('Test in staging') {
        def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/test-deploy-in-staging', returnStdout: true)
        println stdout
      }
    } else {
      echo "Did not receive approval."
      currentBuild.result = 'FAILURE'
    }       
  } catch(err) {
    echo "Exception occured"
    currentBuild.result = "FAILURE"
    mail body: "Project build failure is here: ${env.BUILD_URL}" ,
         from: 'prashanth@infanion',
         replyTo: 'prashanth@infanion.com',
         subject: 'Drupal 8 build failed',
         to: 'i-guide@infanion.com'
    throw err
  }
}


