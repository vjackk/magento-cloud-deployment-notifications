# magento-cloud-deployment-notifications
Magento Cloud Deployment Notifications

## Installation
`composer require composer require vjackk/deployment-notifications`

## Teams Configuration
Create a new incoming webhook following this documentation : https://learn.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/add-incoming-webhook?tabs=newteams%2Cdotnet

## ACC configuration
Add environment variable to Adobe Commerce Cloud project following this doc : https://experienceleague.adobe.com/en/docs/commerce-on-cloud/user-guide/configure/env/stage/variables-admin
- Variable name = TEAMS_WEBHOOK_URL
- Value = Teams webhook URL

Deploy environment and check if messages has been triggered on Teams channel.
