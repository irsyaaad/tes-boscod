## TES TAHAP II BACKEND/FULL STACK PROGRAMMER BOSCOD - IRSYAD
## (SISTEM REST API SEDERHANA CodeIgniter 3 REST API Integration with JWT)


***********
**Instruksi**
***********

- Buat database dengan nama tes_boscod di phpmyadmin.
- Import .sql file yang berada di folder db.
- Register User.
- atau bisa gunakan untuk data dummy
username : irsyad
password : irsyad

username : user@boscod.com
password : rahasia

- Login dengan user yang sudah didaftarkan tadi untuk mendapatakan `access_token`.
- Untuk melakukan transaksi transfer, taruh `access_token` di header dengan nama `Authorization`, dan isi data transaksi di body.

> [!IMPORTANT]
> Expired `access_token` Disetting 1 menit.


**Methods**
***********************

#### Register & Login

POST : [http://localhost/test-boscod/register](http://localhost/test-boscod/register)

|Body     |
|---------|
|username |
|email    |
|password |

POST : [http://localhost/tes-boscod/api/auth/login](http://localhost/tes-boscod/api/auth/login)

|Body     |
|---------|
|username |
|password |



#### Transaksi Transfer
POST : [http://localhost/tes-boscod/api/transfer](http://localhost/tes-boscod/api/transfer)
|Headers      |Body     		|
|-------------|-----------------|
|Authorization|nilai_transfer   |
|             |bank_tujuan    	|
|             |rekening_tujuan  |
|             |atasnama_tujuan  |
|             |bank_pengirim    |


### Token Regeneration

POST : [http://localhost/tes-boscod/api/auth/update-token](http://localhost/tes-boscod/api/auth/update-token)


*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.
It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.
