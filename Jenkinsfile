#!/usr/bin/env groovy



node { // node/agent
    
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
    
  stage('Stage 1') {
    echo 'Hello World' // echo Hello World
  }
}
