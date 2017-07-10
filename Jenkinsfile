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
    stage 'Approve deploy to test' {
      timeout(time: 1, unit: 'HOURS') {
        input 'Deploy to staging?'
      }
    }

    stage 'Deploy to staging' {
      echo "Deploy to staging complete."
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

input
