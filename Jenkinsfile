#!/usr/bin/env groovy

triggers {
    GenericTrigger(
     genericVariables: [
      [key: 'ref', value: '$.ref']
     ],
     causeString: 'Triggered on $ref',
     regexpFilterExpression: '',
     regexpFilterText: '',
     printContributedVariables: true,
     printPostContent: true
    )
  }

node { // node/agent
  stage('Stage 1') {
    echo 'Hello World' // echo Hello World
  }
}
