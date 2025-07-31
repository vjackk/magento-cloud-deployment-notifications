# magento-cloud-deployment-notifications
Magento Cloud Deployment Notifications

## Installation
`composer require vjackk/deployment-notifications`

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

## Create custom message in Magento module
### Create an XML scenario (for example in app/code/Vendor/Module/scenario/test.xml)
```xml
<?xml version="1.0"?>
<scenario xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:ece-tools:config/scenario.xsd">
    <step name="test-notification" type="Vjackk\DeploymentNotifications\Step\SendNotification" priority="10">
        <arguments>
            <argument name="util" xsi:type="object">Vjackk\DeploymentNotifications\Tools\Util</argument>
            <argument name="webhook-data" xsi:type="object">Vjackk\DeploymentNotifications\Config\WebhookData</argument>
            <argument name="teams-service" xsi:type="object">Vjackk\DeploymentNotifications\Service\Teams</argument>
            <argument name="step-code" xsi:type="string">TEST</argument>
            <argument name="message-wrapper" xsi:type="array">
                <item name="message" xsi:type="string">A test message %s - %s.</item>
                <item name="argument-1" xsi:type="string">Text variable</item>
                <item name="argument-2" xsi:type="object">Afflelou\TestNotification\Model\Variable\GetVariable</item>
            </argument>
        </arguments>
    </step>
    <onFail>
        <action name="test-failed-notification" type="Vjackk\DeploymentNotifications\OnFail\Action\SendNotification" priority="200">
            <arguments>
                <argument name="util" xsi:type="object">Vjackk\DeploymentNotifications\Tools\Util</argument>
                <argument name="webhook-data" xsi:type="object">Vjackk\DeploymentNotifications\Config\WebhookData</argument>
                <argument name="teams-service" xsi:type="object">Vjackk\DeploymentNotifications\Service\Teams</argument>
                <argument name="step-code" xsi:type="string">TEST</argument>
                <argument name="message-wrapper" xsi:type="array">
                    <item name="message" xsi:type="string">Failure message %s - %s.</item>
                    <item name="argument-1" xsi:type="string">Other Text variable</item>
                    <item name="argument-2" xsi:type="object">Afflelou\TestNotification\Model\Variable\GetVariable</item>
                </argument>
            </arguments>
        </action>
    </onFail>
</scenario>
```

- step-code is displayed in logs to identify the step
- message-wrapper is an array. The First element is the message, and the following are parameters. A string parameter is displayed normally. An object parameter uses a class which implements a `Vjackk\DeploymentNotifications\Model\Variable\VariableInterface` and uses an execute method to compute the text

Warning : Adobe Commerce and Adobe Cloud have two separated infrastructures. It's impossible to call some Adobe Cloud classes from Adobe Commerce and vice versa