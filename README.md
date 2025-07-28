# magento-cloud-deployment-notifications
Magento Cloud Deployment Notifications

## Installation
`composer require composer require vjackk/deployment-notifications`

## Teams Configuration
- Create a new incoming webhook following this documentation : https://learn.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook?tabs=newteams%2Cdotnet
- Copy the generated URL.

## ACC configuration
Add environment variable to Adobe Commerce Cloud project following this doc : https://experienceleague.adobe.com/en/docs/commerce-on-cloud/user-guide/configure/env/stage/variables-admin
- Variable name = `TEAMS_WEBHOOK_URL`
- Value = URL in previous step

## Project configuration
- Add `php ./vendor/bin/ece-tools run vendor/vjackk/deployment-notifications/scenario/build/generate.xml` in the build part of `.magento.app.yaml`
- Add `php ./vendor/bin/ece-tools run vendor/vjackk/deployment-notifications/scenario/deploy.xml` in the deploy part of `.magento.app.yaml`
- Add `php ./vendor/bin/ece-tools run vendor/vjackk/deployment-notifications/scenario/post-deploy.xml` in the post_deploy part of `.magento.app.yaml`

## Test
Deploy environment and check if messages has been displayed on Teams channel.
