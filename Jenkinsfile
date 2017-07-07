node('master') {
  currentBuild.result = "SUCCESS"
  try {
    stage('Build for Dev') {
      echo 'Build complete for dev..'
    }

    stage('Deploy to Dev') {
      def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-dev', returnStdout: true)
      println stdout
    }
  } catch(err) {
    currentBuild.result = "FAILURE"
            mail body: "project build error is here: ${env.BUILD_URL}" ,
            from: 'prashanth@infanion',
            replyTo: 'prashanth@infanion.com',
            subject: 'Drupal 8 build failed',
            to: 'venkat@infanion.com'
    throw err
  }
}

  
