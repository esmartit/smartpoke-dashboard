
    def label = "worker-${UUID.randomUUID().toString()}"
    podTemplate(label: label, serviceAccount: 'jenkins',
            containers: [
            containerTemplate(name: 'docker', image: 'docker:17.12.1-ce', ttyEnabled: true, command: 'cat', envVars: [envVar(key: 'DOCKER_HOST', value: 'tcp://dind.devops:2375')]),
            containerTemplate(name: 'helm', image: 'lachlanevenson/k8s-helm:v3.0.2', ttyEnabled: true, command: 'cat'),
            containerTemplate(name: 'semantic-release', image: '3apaxicom/npx:latest', ttyEnabled: true, command: 'cat')
            ]
    ) {

        node(label) {
            // Checkout code
            container('jnlp') {
                stage('Checkout code') {
                    checkout scm
                    sh "printenv"
                    git branch: 'gh-pages', changelog: false, credentialsId: 'esmartit-github-username-pass', poll: false, url: 'https://github.com/esmartit/smartpoke-dashboard.git'
                    sh "ls"
                    sh "touch hello.txt"
                    sh "echo world >> hello.txt"
                    sh "git add ."
                    sh "git config --global user.email 'tech@esmartit.es'"
                    sh "git config --global user.name 'esmartit'"
                    sh "git commit -m 'test commit'"
                    withCredentials([usernamePassword(
                        credentialsId: 'esmartit-github-username-pass',
                        usernameVariable: 'username', passwordVariable: 'password')]){
                        //sh "git push https://$username:$password@github.com/esmartit/smartpoke-dashboard.git"
                    }
                }
            }
        }
    }
