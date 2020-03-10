
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
            containerTemplate(name: 'semantic-release', image: 'esmartit/semantic-release:1.0.3', ttyEnabled: true, command: 'cat',envVars: [envVar(key: 'GITHUB_TOKEN', value: env.GITHUB_TOKEN)])
            ]
    ) {

        node(label) {
            // Checkout code
            container('jnlp') {
                stage('Checkout code') {
                    git branch: '${BRANCH_NAME}', credentialsId: 'github', url: repoUrl
                }
            }

            container('semantic-release'){

                stage('Prepare release') {
                    sh "chmod +x prepare-release.sh"
                    sh "npx semantic-release"
                }

                if(env.BRANCH_NAME=='master'){
                    stage('Deploy to GH-PAGES release') {
                        def exists = fileExists 'version.txt'
                        if (exists) {
                            def version = readFile('version.txt').toString().replaceAll("[\\n\\t ]", "")
                            sh "rm version.txt"
                            git branch: 'gh-pages', credentialsId: 'github', url: repoUrl
                            sh "git config --global user.email 'tech@esmartit.es'"
                            sh "git config --global user.name 'esmartit'"
                            def artifactName = "smartpoke-dashboard-${version}.tgz"
                            sh "mv ${artifactName} docs"
                            sh "helm repo index docs --merge docs/index.yaml --url $repoUrl/docs "
                            sh "git add ."
                            sh "git status"
                            sh "git commit -m \"adding new artifact\""
                            withCredentials([usernamePassword(
                                credentialsId: 'esmartit-github-username-pass',
                                usernameVariable: 'username', passwordVariable: 'password')]){
                                    sh "git push https://$username:$password@github.com/esmartit/smartpoke-dashboard.git"
                            }
                        }
                    }
                }
            }
        }
    }
