<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "unduhan_file".
 *
 * @property int $id
 * @property int|null $refunduhan_id
 * @property string|null $file
 * @property string|null $tanggalUpload
 */
class UnduhanFile extends \yii\db\ActiveRecord
{
    /**
     * Atribut virtual untuk menampung file yang diunggah.
     *
     * Sengaja dipisahkan dari kolom `file`. Kolom `file` hanya menyimpan
     * NAMA file (string), sedangkan `fileUpload` menampung objek
     * UploadedFile saat form dikirim. Kalau keduanya digabung, validasi
     * akan gagal setiap kali record lama disimpan ulang.
     *
     * @var \yii\web\UploadedFile|null
     */
    public $fileUpload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unduhan_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['refunduhan_id'], 'integer'],
            [['tanggalUpload'], 'safe'],

            // ---- kolom database: hanya nama file, bukan jalur ----
            [['file'], 'string', 'max' => 255],

            // Tolak jalur direktori dan traversal.
            // Pola ini sengaja longgar soal spasi dan tanda kurung supaya
            // nama file lama yang sudah ada di database tetap bisa disimpan.
            [['file'], 'match',
                'pattern' => '#[/\\\\]|\.\.#',
                'not'     => true,
                'message' => 'Nama file tidak boleh mengandung jalur direktori.',
            ],

            // Tolak ekstensi yang bisa dieksekusi server
            [['file'], 'match',
                'pattern' => '/\.(php|phtml|phar|php[0-9]|inc|sh|pl|py|cgi|htaccess)$/i',
                'not'     => true,
                'message' => 'Jenis file tidak diizinkan.',
            ],

            // ---- atribut unggahan ----
            [['fileUpload'], 'file',
                'skipOnEmpty' => true,
                'maxFiles'    => 1,
                'extensions'  => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png'],
                'maxSize'     => 20 * 1024 * 1024,
                'tooBig'      => 'Ukuran file maksimal 20 MB.',
                'wrongExtension' => 'Hanya file {extensions} yang diizinkan.',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'refunduhan_id' => 'Refunduhan ID',
            'file' => 'File',
            'fileUpload' => 'File',
            'tanggalUpload' => 'Tanggal Upload',
        ];
    }

    public function getUnduhan()
    {
        return $this->hasOne(Unduhan::class, ['id' => 'refunduhan_id']);
    }
}