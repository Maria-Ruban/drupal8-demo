node('master') {
  currentBuild.result = "SUCCESS"
  try {
    stage('Deploy to Dev') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-dev', returnStdout: true)
      println stdout
      mail body: "Project deployed successful\n\r Build number : ${env.BUILD_NUMBER}\n\r Build URL : ${env.BUILD_URL}",
           from: 'prashanth@infanion',
           replyTo: 'prashanth@infanion.com',
           subject: 'Drupal 8 build successful',
           to: 'i-guide@infanion.com'
    }
    stage('Test in Dev') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/test-deploy-in-dev', returnStdout: true)
      println stdout
    }

    def userInput
    stage('Approve deploy to test') {
      try {
        userInput = input(
          id: 'approve-deploy-to-test', message: 'Approve deploy to test env?', parameters: [
            [$class: 'BooleanParameterDefinition', defaultValue: true, description: 'Testing', name: 'I agree to deploy to test.']
          ])
      } catch(err) { // input false
          def user = err.getCauses()[0].getUser()
          userInput = false
          echo "Aborted by: [${user}]"
      }
    }
    if (userInput == true) {
      stage('Deploy to test') {
        def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-test', returnStdout: true)
        println stdout
      }

      stage('Test in test') {
        def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/test-deploy-in-test', returnStdout: true)
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


