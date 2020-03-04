
    def label = "worker-${UUID.randomUUID().toString()}"
    podTemplate(label: label, serviceAccount: 'jenkins', 
            containers: [
            containerTemplate(name: 'docker', image: 'docker:17.12.1-ce', ttyEnabled: true, command: 'cat', envVars: [envVar(key: 'DOCKER_HOST', value: 'tcp://dind.devops:2375')])
            ]
    ) {

        node(label) {
            // Checkout code
            container('jnlp') {
                stage('Checkout code') {
                    checkout scm
                    env.commit = sh returnStdout: true, script: 'git rev-parse HEAD'
                }
            }
        }
    }
