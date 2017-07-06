node('master') {
  stage 'Build for Dev'  
  echo 'Build complete for dev..'

  stage 'Deploy to Dev'
  def stdout = sh(script: 'ansible-playbook playbooks/deploy-to-dev', returnStdout: true)
  println stdout
}

  
