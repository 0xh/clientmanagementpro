<?php

namespace App\Traits\Sluggable;

trait UserSluggable
{
    public function sluggable()
    {
        return [
            'username' => [
                'source' => 'name'
            ]
        ];
    }
    public function forbiddenSlug()
    {
        return 
        ['about', 'abuse', 'account', 'accounts', 'admin', 'admins', 'administrator',
        'administrators', 'anonymous', 'assets', 'billing', 'billings', 'board', 'calendar',
        'contact', 'copyright', 'e-mail', 'email', 'example', 'feedback', 'forum',
        'hostmaster', 'image', 'images', 'inbox', 'index', 'invite', 'jabber', 'legal',
        'launchpad', 'manage', 'media', 'messages', 'mobile', 'official', 'payment',
        'picture', 'pictures', 'policy', 'portal', 'postmaster', 'press', 'privacy',
        'private', 'profile', 'search', 'sitemap', 'staff', 'stage', 'staging', 'static',
        'stats', 'status', 'support', 'teams', 'username', 'usernames', 'users', 'webmail',
        'webmaster', 'login', 'register', 'dashboard', 'backoffice', 'use', 'jars', 'main',
        'data', 'api', 'www', 'test', 'heldesk', 'superadmin', 'gallery', 'employee',
        'employees', 'client', 'clients', 'client-portal', 'spam','public', 'free', 'coupon',
        'coupons', 'discount', 'discounts', 'paid', 'thankyou', 'thank-you', 'blog'];
    }
}