<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Ban Release Description
    |--------------------------------------------------------------------------
    |
    | Set the ban release description name list.
    | 'release' => [
    | Description code project => Ban release description
    | ]
    */

    'release' => [
        'global' => 'Global Service',
        'admin' => 'Admin Service',
        'member' => 'Member Service',
        'server' => 'Server Service',
        'business' => 'Business Service',
     ],

    /*
    |--------------------------------------------------------------------------
    | API Interface Route Name Description
    |--------------------------------------------------------------------------
    |
    | Set the route name relative interface name list.
    | 'interface' => [
    | Route name => Route name description
    | ]
    */

    'interface' => [
        'auth.client.index' => 'Client Service Index',
        'auth.client.build' => 'Build Client Service',
        'auth.client.bans' => 'Search Client Service Bans',
        'auth.client.ban' => 'Search Client Service Ban',
        'auth.client.read' => 'Search Client Service Info',
        'auth.client.rewrite.ban' => 'Edit Client Service Ban',
        'auth.client.disable' => 'Disable Client Service',
        'auth.client.enable' => 'Enable Client Service',
        'auth.client.rename' => 'Rename Client Service',
        'auth.client.reset.secret' => 'Reset Client Service Secret Key',
        'auth.user.types' => 'Login Types',
        'auth.user.login' => 'User Login',
        'auth.user.logout' => 'User Logout',
        'auth.user.signature' => 'User Authorization Signature',
        'auth.user.signature.login' => 'User Signature Login',
        'auth.read.service' => 'Read Own Service Info',
        'auth.token.create' => 'Login Client Service',
        'auth.token.revoke' => 'Revoke Access Token',
        'auth.token.refresh' => 'Refresh Access Token',
        'feature.index' => 'Feature Index',
        'feature.read' => 'Search Feature Info',
        'system.interface.index' => 'All APIs Index',
        'system.interface.managed' => 'Managed APIs Index',
        'system.interface.managed.ban' => 'Search Managed APIs By Ban Number',
        'system.language.index' => 'API Language Index',
        'system.language.default' => 'API Language Default',
        'system.log.types' => 'System Log Types',
        'system.log.index' => 'System Log Index',
        'system.parameter.index' => 'System Parameter Index',
        'system.parameter.read' => 'Search System Parameter Info',
        'system.parameter.rewrite.value' => 'Edit System Parameter Value',
        'system.authority.types' => 'User Authority Types',
        'system.authority.global' => 'Global Authority',
        'system.authority.grant' => 'Grant Authority',
        'system.authority.remove' => 'Remove Authority',
        'system.authority.snapshot.build' => 'Build Authority Snapshot',
        'system.authority.snapshot.index' => 'Authority Snapshot Index',
        'system.authority.snapshot.read' => 'Search Authority Snapshot Info',
        'system.authority.snapshot.rename' => 'Rename Authority Snapshot',
        'system.authority.snapshot.delete' => 'Delete Authority Snapshot',
        'notice.bulletin.build' => 'Build Bulletin Notify Message',
        'notice.bulletin.disable' => 'Disable Bulletin Notify Message',
        'notice.bulletin.enable' => 'Enable Bulletin Notify Message',
        'notice.bulletin.index' => 'Bulletin Notification Index',
        'notice.bulletin.read' => 'Read Bulletin Notification Info',
        'notice.bulletin.user.types' => 'Bulletin Notify Available User Types',
        'notice.messages' => 'User Own Notify Messages',
        'notice.unread' => 'User Own Unread Notice Messages',
        'notice.count' => 'User Own Unread Notice Count',
        'notice.remove' => 'Remove User Own Read Notice Message',
        'notice.remove.all' => 'Remove User Own Read Notice All Messages',
        'sms.log.index' => 'SMS Log Index',
        'sms.log.read' => 'SMS Serial Info',
        'admin.auth.change.password' => 'Admin Change Password',
        'admin.auth.edit.profile' => 'Admin Edit Profile',
        'admin.auth.read' => 'Read Admin Personal Info',
        'admin.user.logon' => 'Create Admin Send Auth Mail',
        'admin.user.resend.auth' => 'Resend Auth Mail',
        'admin.user.index' => 'Admin User Index',
        'admin.user.read' => 'Admin User Info',
        'admin.user.disable' => 'Disable Admin Service',
        'admin.user.enable' => 'Enable Admin Service',
        'trade.log.index' => 'Trade Log Index',
        'trade.log.read' => 'Trade Order Info',
        'trade.log.my' => 'User Own Trade Log Index',
        'trade.log.my.order' => 'User Own Trade Order Info',
        'trade.log.currency.index' => 'Currency Trade Log Index',
        'trade.log.currency.my' => 'User Own Currency Trade Log Index',
        'trade.currency.types' => 'Account Currency Types',
        'trade.currency.types.my' => 'User Own Account Currency Types',
        'trade.currency.account.index' => 'Member Currency Account Index',
        'trade.currency.account.read' => 'Read Member Currency Account Info',
        'trade.currency.account.my' => 'User Own Currency Account Info',
        'receipt.log.index' => 'Receipt Log Index',
        'receipt.log.read' => 'Receipt Order Info',
        'receipt.log.read.main' => 'Receipt Order Master Serial Info',
        'receipt.log.read.last' => 'Receipt Order Last Serial Info',
        'receipt.log.my' => 'User Own Receipt Log Index',
        'receipt.log.my.order' => 'User Own Receipt Order Info',
        'receipt.log.my.order.main' => 'User Own Receipt Order Master Serial Info',
        'receipt.log.my.order.last' => 'User Own Receipt Order Last Serial Info',
        'receipt.form.types' => 'Receipt Form Types',
        'receipt.form.types.my' => 'User Own Receipt Form Types',
        'receipt.form.data.index' => 'Receipt Form Data Index',
        'receipt.form.data.my' => 'User Own Receipt Form Data Index',
    ]
];
