
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
//                     checkout(
//                         scm: [$class: 'GitSCM', branches: [[name: '*/${BRANCH_NAME}'], [name: '*/gh-pages']],
//                         doGenerateSubmoduleConfigurations: false,
//                         extensions: [],
//                         submoduleCfg: [],
//                         userRemoteConfigs: [[credentialsId: 'github', url: 'https://github.com/esmartit/smartpoke-dashboard.git']]])
//                     sh "printenv"
                    git branch: '${BRANCH_NAME}', credentialsId: 'github', url: 'https://github.com/esmartit/smartpoke-dashboard.git'
                    //git branch: 'gh-pages', changelog: false, credentialsId: 'esmartit-github-username-pass', poll: false, url: 'https://github.com/esmartit/smartpoke-dashboard.git'
//                     sh "ls"
                    //sh "touch hello.txt"
                    //sh "echo world >> hello.txt"
                    //sh "git add ."
                    sh "git config --global user.email 'tech@esmartit.es'"
                    sh "git config --global user.name 'esmartit'"
                    //sh "git commit -m 'test commit'"
                    withCredentials([usernamePassword(
                        credentialsId: 'esmartit-github-username-pass',
                        usernameVariable: 'username', passwordVariable: 'password')]){
                        //sh "git push https://$username:$password@github.com/esmartit/smartpoke-dashboard.git"
                    }
                }
            }

            container('semantic-release'){
                sh "chmod +x prepare-release.sh"
                sh "npx semantic-release"


                def exists = fileExists 'version.txt'

                if (exists) {
                    def version = readFile('version.txt').toString().trim()
                    //sh "rm version.txt"
                    git branch: 'gh-pages', credentialsId: 'github', url: 'https://github.com/esmartit/smartpoke-dashboard.git'
                    def command = 'mv smartpoke-dashboard-'.concat(version).concat('.tgz docs/')
                    sh "echo ${command}"
                    sh "git status"
                } else {
                    echo 'No'
                }
            }
        }
    }
