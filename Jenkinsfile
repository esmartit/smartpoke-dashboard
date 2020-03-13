
    withCredentials([usernamePassword(
        credentialsId: 'github',
        usernameVariable: 'username', passwordVariable: 'gitToken')]){
            env.GITHUB_TOKEN=gitToken
        }
    withCredentials([usernamePassword(
        credentialsId: 'docker-credentials',
        usernameVariable: 'dockerUser', passwordVariable: 'dockerPass')]){
            env.DOCKER_USER=dockerUser
            env.DOCKER_PASS=dockerPass
        }
    def repoUrl = "https://github.com/esmartit/smartpoke-dashboard.git"
    def label = "worker-${UUID.randomUUID().toString()}"
    podTemplate(label: label, serviceAccount: 'jenkins',
            containers: [
            containerTemplate(name: 'semantic-release', image: 'esmartit/semantic-release:1.0.3', ttyEnabled: true, command: 'cat',
            envVars: [
                envVar(key: 'GITHUB_TOKEN', value: env.GITHUB_TOKEN),
                envVar(key: 'DOCKER_HOST', value: 'tcp://dind.devops:2375')])
            ]
    ) {

        node(label) {

            try{

                notifySlack()

                container('semantic-release'){

                    stage('Checkout code') {
                        checkout scm
                    }

                    stage('Prepare release') {
                        sh "chmod +x prepare-release.sh"
                        sh "npx semantic-release"
                    }

                    if(env.BRANCH_NAME=='master'){
                        stage('Deploy Helm Package') {
                            def exists = fileExists 'version.txt'
                            if (exists) {
                                def version = readFile('version.txt').toString().replaceAll("[\\n\\t ]", "")
                                sh "rm version.txt"
                                git branch: 'gh-pages', credentialsId: 'github', url: repoUrl
                                sh "git config --global user.email 'tech@esmartit.es'"
                                sh "git config --global user.name 'esmartit'"
                                def artifactName = "smartpoke-dashboard-${version}.tgz"
                                sh "mv ${artifactName} docs"
                                sh "helm repo index docs --merge docs/index.yaml --url https://esmartit.github.io/smartpoke-dashboard/docs"
                                sh "git add ."
                                sh "git status"
                                sh "git commit -m \"adding new artifact version: $version\""
                                withCredentials([usernamePassword(
                                    credentialsId: 'esmartit-github-username-pass',
                                    usernameVariable: 'username', passwordVariable: 'password')]){
                                        sh "git push https://$username:$password@github.com/esmartit/smartpoke-dashboard.git"
                                }
                            }
                        }
                    }
                }


            } catch (e) {
                // If there was an exception thrown, the build failed
                currentBuild.result = "FAILED"
                throw e
            } finally {
                // Success or failure, always send notifications
                notifySlack(currentBuild.result)
            }
        }
    }

    def notifySlack(String buildStatus = 'STARTED') {
        // Build status of null means success.
        buildStatus = buildStatus ?: 'SUCCESS'

        def color

        if (buildStatus == 'STARTED') {
            color = '#D4DADF'
        } else if (buildStatus == 'SUCCESS') {
            color = '#BDFFC3'
        } else if (buildStatus == 'UNSTABLE') {
            color = '#FFFE89'
        } else {
            color = '#FF9FA1'
        }

        def msg = "${buildStatus}: `${env.JOB_NAME}` #${env.BUILD_NUMBER}:\n${env.BUILD_URL}"

        slackSend(channel: 'builds',color: color, message: msg, tokenCredentialId: 'slack-token')
    }
