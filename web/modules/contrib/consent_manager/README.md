## INTRODUCTION ##

The consentmanager.net CMP (Consent Management Provider) allows your to easily
collect consent from your websites visitors in order to become GDPR and CCPA
compliant.

## HOW DOES IT WORK? ##
Our CMP solution is very simple to integrate: Simply log in to your
[consentmanager.net](https://consentmanager.net/) account, setup your
website(s), create the code and paste it into your website/plugin. Our platform
will automatically start gathering consent from your visitors. As soon as
the code is in your website, advertisers will have access to the consent
data via the open source API defined by the IAB.

In addition you will get detailed reports which show you how your visitors are
behaving with the consent layer, how many consents you get and how you can
optimize your strategie in order to obtain higher rates of consent.


## REQUIREMENTS ##

- Need to have an account on the [consentmanager.net](https://consentmanager.net/) site.

## INSTALLATION ##

- Install as you would normally install a contributed Drupal module. Visit
  https://www.drupal.org/documentation/install/modules-themes/modules-8
  for further information.

## CONFIGURATION ##

Simple installation:
1. Install our module.
2. Get your Consent Manager code at
   [consentmanager.net](https://www.consentmanager.net/client/codes.php)
3. Insert code on the module settings page
   (`/admin/config/services/consent-manager`).

That’s all!


## FAQ ##


### Do I need a CMP? ###

Short answer: Probably yes. Long answer: If your company is based in the EEA
(European Economic Area) or if you are dealing with customers/visitors from
this area and show them advertising, it is very likely that you will collect
and/or process personal data such as IP-addresses. Therefore, according to GDPR,
you need to make sure that the visitor is informed and you need to ask the user
for consent. In order to do this you will need a CMP.

### When does this become necessary? ###

GDPR is "active" since 25. of May 2018. From this day on you will probably need
a CMP and pubvendors.json.

### How do I obtain consent from my visitors? ###

By integrating our CMP into your website ;-) Our CMP will display a message to
visitors and ask them to give consent. We will then store this choice and make
it available to your advertisers and other vendors (tools) so that they know
if/how they can work with personal data.

### Will the CMP block advertisers from my page do not have consent? ###

Yes, our CMP offers a solution to block advertisers/codes that do not have
consent from the visitor.

### Is it complicated? ###

No! In the simplest case you only have to integrate a code into your
website - that's all!

### Your question is missing here? ###

Any question that you think is missing here? Get in touch with us and t
ell us your questions!
