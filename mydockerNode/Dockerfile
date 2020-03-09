FROM node:alpine3.11

ENV GITHUB_TOKEN=123

RUN npm install -g semantic-release               \
        @semantic-release/changelog               \
        @semantic-release/commit-analyzer         \
        @semantic-release/exec                    \
        @semantic-release/git                     \
        @semantic-release/release-notes-generator

RUN apk --no-cache add git

RUN git --version