<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Localidade;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\ValidationUser;
use App\Repository\UserRepositoryInterface;

class EmbyService
{


private  $apikey="0b1cf66f4180462c95158b1dacc219c1";



public function emby($user){



    $vasio="";
    $ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "http://emby.videotecapopular.com.br:8096/emby/Users/New?api_key={$this->apikey}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"Name\":\"{$user['nome_completo']}\"}");

	$headers = array();
	$headers[] = 'Accept: application/json';
	$headers[] = 'Content-Type: application/json';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);



	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
curl_close($ch);

$json = json_decode($result, true);


$userid = $json['Id'];


$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "http://emby.videotecapopular.com.br:8096/emby/Users/{$userid}/Connect/Link?api_key={$this->apikey}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"ConnectUsername\":\"{$user['email']}\"}");

	$headers = array();
	$headers[] = 'Accept: application/json';
	$headers[] = 'Content-Type: application/json';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result2 = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
curl_close($ch);

$json2 = json_decode($result2, true);
$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "http://emby.videotecapopular.com.br:8096/emby/Users/{$userid}/Policy?api_key={$this->apikey}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"IsAdministrator\":false,\"IsHidden\":true,\"IsHiddenRemotely\":true,\"IsDisabled\":false,\"MaxParentalRating\":0,\"BlockedTags\":[\"\"],\"IsTagBlockingModeInclusive\":false,\"EnableUserPreferenceAccess\":true,\"AccessSchedules\":[\"\"],\"BlockUnratedItems\":[\"\"],\"EnableRemoteControlOfOtherUsers\":false,\"EnableSharedDeviceControl\":true,\"EnableRemoteAccess\":true,\"EnableLiveTvManagement\":true,\"EnableLiveTvAccess\":true,\"EnableMediaPlayback\":true,\"EnableAudioPlaybackTranscoding\":true,\"EnableVideoPlaybackTranscoding\":true,\"EnablePlaybackRemuxing\":true,\"EnableContentDeletion\":false,\"EnableContentDeletionFromFolders\":[\"\"],\"EnableContentDownloading\":false,\"EnableSubtitleDownloading\":false,\"EnableSubtitleManagement\":false,\"EnableSyncTranscoding\":true,\"EnableMediaConversion\":true,\"EnabledDevices\":[\"string\"],\"EnableAllDevices\":true,\"EnabledChannels\":[\"\"],\"EnableAllChannels\":true,\"EnabledFolders\":[\"\"],\"EnableAllFolders\":true,\"InvalidLoginAttemptCount\":0,\"EnablePublicSharing\":true,\"BlockedMediaFolders\":[\"\"],\"BlockedChannels\":[\"\"],\"RemoteClientBitrateLimit\":0,\"AuthenticationProviderId\":\"Emby.Server.Implementations.Library.DefaultAuthenticationProvider\",\"ExcludedSubFolders\":[\"\"],\"DisablePremiumFeatures\":false,\"SimultaneousStreamLimit\":0}");

	$headers = array();
	$headers[] = 'Accept: */*';
	$headers[] = 'Content-Type: application/json';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result4 = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
curl_close($ch);

$json4 = json_decode($result4, true);



$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://emby.videotecapopular.com.br:8096/emby/Users/{$userid}/Password?api_key={$this->apikey}");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"Id\":\"{$userid}\",\"CurrentPassword\":\"{$vasio}\",\"NewPassword\":\"{$user['password']}\",\"ResetPassword\":true}");

	$headers = array();
	$headers[] = 'Accept: application/json';
	$headers[] = 'Content-Type: application/json';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result5 = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
curl_close($ch);

$json4 = json_decode($result5, true);

}





}
