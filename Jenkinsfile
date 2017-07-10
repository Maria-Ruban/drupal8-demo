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

    //stage('Approve deploy to test') {
    //  timeout(time: 1, unit: 'HOURS') {
    //    input 'Deploy to staging?'
    //  }
    //}

    def userInput
    stage('Approve deploy to test') {
      try {
          userInput = input(
              id: 'Proceed1', message: 'Was this successful?', parameters: [
              [$class: 'BooleanParameterDefinition', defaultValue: true, description: '', name: 'Please confirm you agree with this']
              ])
      } catch(err) { // input false
          def user = err.getCauses()[0].getUser()
          userInput = false
          echo "Aborted by: [${user}]"
      }
    }
    if (userInput == true) {
      // do something
      echo "this was successful"
      stage('Deploy to staging') {
        echo "Deploy to staging complete."
      }
    } else {
      // do something else
      echo "this was not successful"
      currentBuild.result = 'FAILURE'
    }    
  } catch(err) {
    currentBuild.result = "FAILURE"
    mail body: "Project build failure is here: ${env.BUILD_URL}" ,
         from: 'prashanth@infanion',
         replyTo: 'prashanth@infanion.com',
         subject: 'Drupal 8 build failed',
         to: 'i-guide@infanion.com'
    throw err
  }
}


