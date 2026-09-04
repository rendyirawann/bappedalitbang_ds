<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior; // Tambahkan ini
use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    
    // Virtual attribute untuk input password mentah (agar tidak langsung akses password_hash)
    public $password; 

    public static function tableName()
    {
        return 'user';
    }

    /**
     * BEHAVIOR OTOMATIS
     * Ini akan otomatis mengisi created_at dan updated_at.
     * Jadi attacker TIDAK BISA memalsukan tanggal pembuatan.
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            // 1. Field yang WAJIB diisi user hanyalah username dan email
            [['username', 'email'], 'required'],

            // 2. Password hanya wajib saat skenario 'create' (bikin baru)
            // Saat update, jika kosong berarti tidak ganti password
            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],

            // 3. Validasi tipe data
            [['status', 'bidang_id'], 'integer'],
            [['username'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique'], // Pastikan unique
            [['email'], 'email'],

            // 4. Default value untuk status (jika tidak diisi, otomatis Aktif/Inactive sesuai kebutuhan)
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            // 5. Validasi relasi
            [['bidang_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bidang::class, 'targetAttribute' => ['bidang_id' => 'id']],

            // PENTING: Hapus 'auth_key', 'password_hash', 'created_at', 'updated_at' dari rules
            // agar tidak bisa di-inject via form input (Mass Assignment).
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password', // Label untuk virtual attribute
            'email' => 'Email',
            'status' => 'Status',
            'bidang_id' => 'Bidang',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diubah Pada',
        ];
    }

    /**
     * LOGIKA SEBELUM SIMPAN (BEFORE SAVE)
     * Kita generate hash dan auth key di sini secara otomatis.
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Jika user menginput password baru, kita hash di sini
        if (!empty($this->password)) {
            $this->setPassword($this->password);
        }

        // Jika ini data baru, generate Auth Key otomatis
        if ($insert) {
            $this->generateAuthKey();
        }

        return true;
    }

    // ... (Sisa method relasi dan identity tetap sama seperti kode lama kamu di bawah ini) ...
    
    public static function getStatusOptions()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_DELETED => 'Deleted',
        ];
    }

    public function getBidang()
    {
        return $this->hasOne(Bidang::class, ['id' => 'bidang_id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new \yii\base\NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}