node('master') {
  stage 'Build for Dev'  
  echo 'Build complete for dev..'

  stage 'Deploy to Dev'
  ansible-playbook /home/ubuntu/playbooks/deploy-to-dev
}

  
