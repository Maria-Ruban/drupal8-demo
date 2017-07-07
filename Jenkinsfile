node('master') {
  currentBuild.result = "SUCCESS"
  try {
    stage('Build for Dev') {
      echo 'Build complete for dev..'
    }

    stage('Deploy to Dev') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-dev', returnStdout: true)
      println stdout
      mail body: "Project build successful<br> Build number : ${env.BUILD_NUMBER}<br> Build URL : ${env.BUILD_URL}",
           from: 'prashanth@infanion',
           replyTo: 'prashanth@infanion.com',
           subject: 'Drupal 8 build successful',
           to: 'i-guide@infanion.com'
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

  
