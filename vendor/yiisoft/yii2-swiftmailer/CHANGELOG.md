Yii Framework 2 swiftmailer extension Change Log
================================================

2.0.6 September 09, 2016
------------------------

- Enh #6: Added ability to specify custom mail header at `yii\swiftmailer\Message` (klimov-paul)
- Enh #23: Added `yii\swiftmailer\Message::setReturnPath()` shortcut method (klimov-paul)
- Enh #27: Added ability to specify message signature (klimov-paul)
- Enh #32: Added `yii\swiftmailer\Message::setReadReceiptTo()` shortcut method (klimov-paul)
- Enh: Added `yii\swiftmailer\Message::setPriority()` shortcut method (klimov-paul)


2.0.5 March 17, 2016
--------------------

- Bug #9: Fixed `Mailer` does not check if property is public, while configuring 'Swift' object (brandonkelly, klimov-paul)


2.0.4 May 10, 2015
------------------

- Enh #4: Added ability to pass SwiftMailer log entries to `Yii::info()` (klimov-paul)


2.0.3 March 01, 2015
--------------------

- no changes in this release.


2.0.2 January 11, 2015
----------------------

- no changes in this release.


2.0.1 December 07, 2014
-----------------------

- no changes in this release.


2.0.0 October 12, 2014
----------------------

- no changes in this release.


2.0.0-rc September 27, 2014
---------------------------

- no changes in this release.


2.0.0-beta April 13, 2014
-------------------------

- Bug #1817: Message charset not applied for alternative bodies (klimov-paul)

2.0.0-alpha, December 1, 2013
-----------------------------

- Initial release.
