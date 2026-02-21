CodeBuild / CodePipeline Console Setup (no terminal)
-------------------------------------------------

This repository includes `buildspec.yml` at the project root. The file
`aws/codebuild-stack.yml` is a CloudFormation template that creates an S3
artifact bucket and an IAM role for CodeBuild. Follow the steps below to
create resources and a CodeBuild project using the AWS Console (no CLI needed).

1) Create the CloudFormation stack (Console)
   - Open the AWS Console → CloudFormation → Create stack → With new resources.
   - Upload the template file: select `aws/codebuild-stack.yml` from this repo.
   - Parameters:
     - `ArtifactBucketName`: pick a globally unique bucket name (e.g. `lm-artifacts-<yourname>`)
     - `CodeBuildRoleName`: optional, default `LMCodeBuildServiceRole`
   - Create the stack and wait for it to finish. After success, note the
     `ArtifactBucketName` and the `CodeBuildRoleArn` shown in Outputs.

2) Create a CodeBuild project (Console)
   - Open the AWS Console → CodeBuild → Create project.
   - Project name: e.g. `LM-CodeBuild-Project`.
   - Source provider: `GitHub` (or `GitHub Enterprise / Bitbucket` depending on your repo).
     - Click `Connect new repository` and follow the OAuth flow to authorize.
     - Select the repository `owner/repo` and the branch (e.g. `main`).
   - Environment:
     - Environment image: `Managed image`
     - Operating system: `Ubuntu`
     - Runtime: `Standard`
     - Image: choose a recent `aws/codebuild/standard` image (e.g. `aws/codebuild/standard:6.0`).
     - Privileged: leave unchecked.
     - Service role: choose `Existing service role` and pick the role created by the
       CloudFormation stack (the name you provided / default `LMCodeBuildServiceRole`).
   - Buildspec: `Use a buildspec file` — leave as `buildspec.yml` (the repo already contains one).
   - Artifacts:
     - Type: `Amazon S3`
     - Bucket: select the bucket created by the CloudFormation stack.
     - Path: leave empty or enter `artifacts`
   - Create the project.

3) Configure environment variables / secrets
   - For DB credentials and `APP_DEBUG`, prefer using Secrets Manager or SSM Parameter Store.
   - In the CodeBuild project → Edit → Environment → Additional configuration → Environment variables
     - Add e.g. `APP_DEBUG` = `1` (for development). For credentials, choose `Parameter store` or
       `Secrets manager` to reference secure values.

4) Start a build
   - In CodeBuild project page click `Start build`.
   - Monitor logs in the build run details (Console) or in CloudWatch Logs.

5) (Optional) Create CodePipeline to trigger builds on push
   - Open AWS Console → CodePipeline → Create pipeline.
   - Source: GitHub, select repository and branch.
   - Build stage: Choose the CodeBuild project you created.
   - Artifact store: Use the S3 bucket created earlier.

Security notes
 - Do NOT hardcode DB credentials in the repository. Use Secrets Manager or SSM Parameter Store.
 - Only enable `APP_DEBUG=1` in non-production builds.

If you want, I can also generate a ready-to-upload CloudFormation stack (with
example parameter values pre-filled), or provide a CloudFormation template that
creates a CodeBuild project which uses a CodeStar GitHub connection — tell me
which approach you'd prefer and I will add the file here.
