
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

            container('docker') {

                stage('Build image') {
                    env.version = sh returnStdout: true, script: 'cat build.number'
                    withEnv(['VERSION=' + env.version.trim(), 'COMMIT=' + env.commit.trim()]) {
                        sh """
                            docker build \
                            -t esmartit/smartpoke-dashboard:${VERSION}.${COMMIT}  \
                            -t esmartit/smartpoke-dashboard:latest \
                            .
                           """
                    }
                }

                stage('Push image') {
                    withDockerRegistry([credentialsId: 'docker-registry-credentials']) {
                        withEnv(['VERSION=' + env.VERSION.trim(), 'COMMIT=' + env.COMMIT.trim()]) {
                            sh "docker push esmartit/smartpoke-dashboard:${VERSION}.${COMMIT}"
                            sh 'docker push esmartit/smartpoke-dashboard:latest'
                        }
                    }
                }
            }
        }
    }
