node('master') {
  stage 'Build for Dev'  
  echo 'Build complete for dev..'

  stage 'Deploy to Dev'
  def stdout = sh(script: 'ansible-playbook /var/lib/jenkins/playbooks/deploy-to-dev', returnStdout: true)
  println stdout
}

  
