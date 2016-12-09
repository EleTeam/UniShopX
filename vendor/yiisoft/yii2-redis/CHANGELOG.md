Yii Framework 2 redis extension Change Log
==========================================

2.0.5 March 17, 2016
--------------------

- Bug #22: Fixed string escaping issue in LuaScriptBuilder (vistart)
- Bug #37: Fixed detection of open socket (mirocow)
- Bug #46: Fixed bug to execute session_regenerate_id in PHP 7.0 (githubjeka)
- Enh #31: Added `Connection::$socketClientFlags` property for connection flags to be passed to `stream_socket_client()` (hugh-lee)
- Chg #14: Added missing `BLPOP` command to `$redisCommands` (samdark)
- Chg #61: Added missing `GEO*` commands to `$redisCommands` (leadermt)


2.0.4 May 10, 2015
------------------

- Enh #8: Auto increment value was not updated when a primary key was explicitly set (cebe, andruha)


2.0.3 March 01, 2015
--------------------

- no changes in this release.


2.0.2 January 11, 2015
----------------------

- Bug #6547: Fixed redis connection to deal with large data in combination with `mget()` (pyurin)


2.0.1 December 07, 2014
-----------------------

- Bug #4745: value of simple string returns was ignored by redis client and `true` is returned instead, now only `OK` will result in a `true` while all other values are returned as is (cebe)
- Enh #3714: Added support for connecting to redis server using a unix socket (savvot, robregonm)


2.0.0 October 12, 2014
----------------------

- no changes in this release.


2.0.0-rc September 27, 2014
---------------------------

- Bug #1311: Fixed storage and finding of `null` and boolean values (samdark, cebe)
- Enh #3520: Added `unlinkAll()`-method to active record to remove all records of a model relation (NmDimas, samdark, cebe)
- Enh #4048: Added `init` event to `ActiveQuery` classes (qiangxue)
- Enh #4086: changedAttributes of afterSave Event now contain old values (dizews)


2.0.0-beta April 13, 2014
-------------------------

- Bug #1993: afterFind event in AR is now called after relations have been populated (cebe, creocoder)
- Enh #1773: keyPrefix property of Session and Cache is not restricted to alnum characters anymore (cebe)
- Enh #2002: Added filterWhere() method to yii\redis\ActiveQuery to allow easy addition of search filter conditions by ignoring empty search fields (samdark, cebe)
- Enh #2892: ActiveRecord dirty attributes are now reset after call to `afterSave()` so information about changed attributes is available in `afterSave`-event (cebe)
- Chg #2281: Renamed `ActiveRecord::create()` to `populateRecord()` and changed signature. This method will not call instantiate() anymore (cebe)
- Chg #2146: Removed `ActiveRelation` class and moved the functionality to `ActiveQuery`.
             All relational queries are now directly served by `ActiveQuery` allowing to use
             custom scopes in relations (cebe)

2.0.0-alpha, December 1, 2013
-----------------------------

- Initial release.
