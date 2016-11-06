<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2015-05-06
 * @email 908601756@qq.com
 * @copyright Copyright © 2015年 EleTeam
 * @license The MIT License (MIT)
 */

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $role
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $avatar
 *
 * @property Forum[] $forums
 * @property ForumBoard[] $forumBoards
 * @property ForumBroadcast[] $forumBroadcasts
 * @property ForumFollow[] $forumFollows
 * @property ForumPost[] $forumPosts
 * @property ForumThread[] $forumThreads
 * @property HomePost[] $homePosts
 * @property UserFollow[] $userFollows
 * @property UserFollow[] $userFollows0
 * @property UserMessage[] $userMessages
 * @property UserMessage[] $userMessages0
 * @property UserProfile $userProfile
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'password_reset_token', 'auth_key', 'role', 'email', 'status', 'created_at', 'updated_at', 'avatar'], 'required'],
            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 60],
            [['password_reset_token'], 'string', 'max' => 43],
            [['email'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 24],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'avatar' => 'Avatar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForums()
    {
        return $this->hasMany(Forum::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumBoards()
    {
        return $this->hasMany(ForumBoard::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumBroadcasts()
    {
        return $this->hasMany(ForumBroadcast::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumFollows()
    {
        return $this->hasMany(ForumFollow::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumPosts()
    {
        return $this->hasMany(ForumPost::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumThreads()
    {
        return $this->hasMany(ForumThread::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomePosts()
    {
        return $this->hasMany(HomePost::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFollows()
    {
        return $this->hasMany(UserFollow::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFollows0()
    {
        return $this->hasMany(UserFollow::className(), ['people_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMessages()
    {
        return $this->hasMany(UserMessage::className(), ['sendfrom' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMessages0()
    {
        return $this->hasMany(UserMessage::className(), ['sendto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }
}
