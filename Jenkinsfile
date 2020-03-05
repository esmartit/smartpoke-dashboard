
    def label = "worker-${UUID.randomUUID().toString()}"
    podTemplate(label: label, serviceAccount: 'jenkins', 
            containers: [
            containerTemplate(name: 'docker', image: 'docker:17.12.1-ce', ttyEnabled: true, command: 'cat', envVars: [envVar(key: 'DOCKER_HOST', value: 'tcp://dind.devops:2375')]),
            containerTemplate(name: 'helm', image: 'lachlanevenson/k8s-helm:v3.0.2', ttyEnabled: true, command: 'cat')]
    ) {

        node(label) {
            // Checkout code
            container('jnlp') {
                stage('Checkout code') {
                    checkout scm
                    env.commit = sh returnStdout: true, script: 'git rev-parse --short HEAD'
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

            container('helm'){
                stage('Package Helm Chart') {
                    withEnv(['VERSION=' + env.version.trim(), 'COMMIT=' + env.commit.trim()]) {
                        sh "sed -i s/0.1.0/${VERSION}.${COMMIT}/g smartpoke-dashboard/Chart.yaml"
                        sh "helm package smartpoke-dashboard"
                    }
                }
            }

            container('jnlp') {
                stage('Switch Branch') {
                    sh "git checkout gh-pages"
                }
            }

            container('helm'){
                stage('Update Helm Repo') {
                    sh "helm repo index docs --merge --url https://esmartit.github.io/smartpoke-dashboard/docs"
                }
            }

            container('jnlp') {
                stage('Deploy Helm Chart') {
                    withEnv(['VERSION=' + env.version.trim(), 'COMMIT=' + env.commit.trim()]) {
                        sh "git add ."
                        sh "git commit -m 'deploying chart with version ${VERSION}.${COMMIT}'"
                        sh "git push"
                    }
                }
            }
        }
    }
