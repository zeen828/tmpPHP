<?php
/*
 >> Information

    Title		: Storage Signature
    Revision	: 1.0.0
    Notes		:

    Revision History:
    When			Create		When		Edit		Description
    ---------------------------------------------------------------------------
    04-14-2020		Poen		10-30-2020	Poen		Code maintenance.
    ---------------------------------------------------------------------------

 >> About

    file > (app/Libraries/Instances/Storage/Signature.php) :
    The functional base class.

    Use Laravel cache mechanism to store driver dynamic processing.

    file > (config/signature.php) :
    The signature driver about config.

    When keep store and interim store are different types, the mode is mixed storage.

    Permanent data is stored on keep store, you can change to other stores in keep_store.

    Time-sensitive data is stored on interim store, you can change to other stores in interim_store.

 >> Artisan Commands

    Set the signature secret key.
    $php artisan signature:secret

 >> Aliases

    use StorageSignature;

 >> Note

    TTL :
    Use the ttl parameter of the build function.
    Specify the length of time (in minutes) that the token will be valid for.
    Defaults to 3 minutes.
    You can also set this to null, to yield a never expiring signature.

 >> Learn

    Usage 1 :
    Obtain the new signature code.

    Example :
    --------------------------------------------------------------------------
    use StorageSignature;

    $ttl = 5;

    $code = StorageSignature::build(['custom'], $ttl);

    Usage 2 :
    Get the data by signature code.

    Example :
    --------------------------------------------------------------------------
    use StorageSignature;

    $ttl = 5;

    $code = StorageSignature::build(['custom'], $ttl);

    $data = StorageSignature::get($code);

    Usage 3 :
    Forget the data by signature code.

    Example :
    --------------------------------------------------------------------------
    use StorageSignature;

    $ttl = 5;

    $code = StorageSignature::build(['custom'], $ttl);

    StorageSignature::forget($code);

    Usage 4 :
    Preload the signature code list and increase query speed.

    Example :
    --------------------------------------------------------------------------
    use StorageSignature;

    $codes = [
       '334eeba482b04d8ebc5077710345834b7e8d20659ee6cb32d34720bb40b12d8441e79970',
       'e42b9e5906534f8baec02bd0f3b8c0a01c59a5328218cc92eefd10976c6c5b5c7a7a7920',
       '59a95a5d9f9b43d6a9cdd9e872fe79c57e8d20659ee6cb32d34720bb40b12d842e28a221'
    ];

    StorageSignature::preload($codes);

    $data = StorageSignature::get($codes[0]);

*/