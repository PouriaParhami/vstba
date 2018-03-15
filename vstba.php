<?php

/**
 *  Welcome to VSTBA V 1.1.2
 *  Very Simple Telegram Bot API
 *  Author: Pouria Parhami
 *  Organization: darkoobweb
 *  URL: http://darkoobweb.com
 *  Date: 6/29/2017
 *
 */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


/**
 *
 * Define Token id and Api Url
 *
 */

define('BOT_TOKEN', '');
define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN);


/**
 *
 * This Function iterate User, Chat, Entities, Photo, Location
 *
 * @param $userData
 * @param $type
 * @param $firsName
 * @param $theArray
 *
 * @return mixed
 *
 */
function iterateDataBasic( $userData, $type, $firsName, $theArray ) {


	switch ( $type ) {

		case 'user':

			foreach ( $userData as $userDataKey => $userDataValue ) {

				switch ( $userDataKey ) {

					case 'id':
						$theArray[ $firsName . 'Id' ] = $userDataValue;
						break;

					case 'first_name':
						$theArray[ $firsName . 'FirstName' ] = $userDataValue;
						break;

					case 'last_name':
						$theArray[ $firsName . 'LastName' ] = $userDataValue;
						break;

					case 'username':
						$theArray[ $firsName . 'UserName' ] = $userDataValue;
						break;

					case 'language_code':
						$theArray[ $firsName . 'LangCode' ] = $userDataValue;
						break;

				}
			}


			break;

		case 'chat':

			foreach ( $userData as $userDataKey => $userDataValue ) {

				switch ( $userDataKey ) {

					case 'id':
						$theArray[ $firsName . 'Id' ] = $userDataValue;
						break;

					case 'type':
						$theArray[ $firsName . 'Type' ] = $userDataValue;
						break;

					case 'title':
						$theArray[ $firsName . 'Title' ] = $userDataValue;
						break;

					case 'username':
						$theArray[ $firsName . 'Username' ] = $userDataValue;
						break;

					case 'first_name':
						$theArray[ $firsName . 'FirstName' ] = $userDataValue;
						break;

					case 'last_name':
						$theArray[ $firsName . 'LastName' ] = $userDataValue;
						break;

					case 'all_members_are_administrators':
						$theArray[ $firsName . 'AllMembersAreAdmin' ] = $userDataValue;
						break;

					case 'photo':
						$theArray[ $firsName . 'Photo' ] = $userDataValue;
						break;

					case 'description':
						$theArray[ $firsName . 'Description' ] = $userDataValue;
						break;

					case 'invite_link':
						$theArray[ $firsName . 'InviteLine' ] = $userDataValue;
						break;

				}
			}

			break;

		case 'entities':

			foreach ( $userData as $userDataKey => $userDataValue ) {

				switch ( $userDataKey ) {

					case 'type':

						$theArray[ $firsName . 'Type' ] = $userDataValue;

						break;

					case 'offset':

						$theArray[ $firsName . 'Offset' ] = $userDataValue;

						break;

					case 'length':

						$theArray[ $firsName . 'Length' ] = $userDataValue;

						break;

					case 'url':

						$theArray[ $firsName . 'Url' ] = $userDataValue;

						break;

					case 'user':

						$theArray = iterateDataBasic( $userData['user'], 'user', 'entitiesUser', $theArray );

						break;
				}
			}
			break;

		case 'photo':

			foreach ( $userData[0] as $userDataKey => $userDataValue ) {

				switch ( $userDataKey ) {

					case 'file_id':
						$theArray[ $firsName . 'FileId' ] = $userDataValue;
						break;

					case 'width':
						$theArray[ $firsName . 'Width' ] = $userDataValue;
						break;

					case 'height':
						$theArray[ $firsName . 'Height' ] = $userDataValue;
						break;

					case 'file_size':
						$theArray[ $firsName . 'gamePhotoFileSize' ] = $userDataValue;
						break;

				}
			}

			break;

		case 'location':

			foreach ( $userData as $userDataKey => $userDataValue ) {

				switch ( $userDataKey ) {

					case 'longitude':
						$theArray[ $firsName . 'FileLongitude' ] = $userDataValue;
						break;

					case 'latitude':
						$theArray[ $firsName . 'Latitude' ] = $userDataValue;
						break;

				}
			}

			break;
	}

	return $theArray;
}


/**
 *
 * function return you an array, information about message, like chat_id, text, phone number
 * It's not complete, but you can add more :)
 *
 * attention: usage is optional
 *
 * @param $data
 *
 * @return array
 *
 *
 */


function userMessageSimplify( $data ) {

	$userMessage = array();

	if ( $data !== null ) {

		foreach ( $data as $key => $value ) {

			if ( $key === 'update_id' ) {

				$userMessage['updateId'] = $value;
			}

			if ( $key === 'message' ) {

				foreach ( $data['message'] as $msKey => $msValue ) {

					switch ( $msKey ) {

						case 'message_id':
							$userMessage['messageId'] = $msValue;
							break;

						case 'date':
							$userMessage['messageDate'] = $msValue;
							break;

						case 'text':
							$userMessage['messageText'] = $msValue;
							break;

						case 'from':

							$userMessage = iterateDataBasic( $data['message']['from'], 'user', 'from', $userMessage );

							break;

						case 'chat':

							$userMessage = iterateDataBasic( $data['message']['chat'], 'chat', 'chat', $userMessage );

							break;

						case 'forward_from':

							$userMessage = iterateDataBasic( $data['message']['forward_from'], 'user', 'forwardFrom', $userMessage );

							break;

						case 'forward_from_chat':

							$userMessage = iterateDataBasic( $data['message']['forward_from_chat'], 'chat', 'forwardFromChat', $userMessage );

							break;

						case 'forward_from_message_id':

							$userMessage['forwardFromMessageId'] = $msValue;

							break;

						case 'forward_date':

							$userMessage['forwardDate'] = $msValue;

							break;

						case 'reply_to_message':

							//thinking about this...

							break;

						case 'edit_date':

							$userMessage['editDate'] = $msValue;

							break;

						case 'entities':

							$userMessage = iterateDataBasic( $data['message']['entities'][0], 'entities', 'entities', $userMessage );

							break;

						case 'audio':

							$userMessage['audio'] = $data['message']['audio'];

							break;

						case 'document':

							$userMessage['document'] = $data['message']['document'];


							break;

						case 'game':

							foreach ( $data['message']['game'] as $gameKey => $gameValue ) {

								switch ( $gameKey ) {

									case 'title':

										$userMessage['gameTitle'] = $gameValue;

										break;

									case 'description':

										$userMessage['gameDescription'] = $gameValue;

										break;

									case 'photo':

										$userMessage = iterateDataBasic( $data['message']['game']['photo'], 'photo', 'gamePhoto', $userMessage );

										break;

									case 'text':

										$userMessage['gameText'] = $gameValue;

										break;

									case 'text_entities':

										foreach ( $data['message']['game']['text_entities'] as $gameTextEntitiKey => $gameTextEntitiValue ) {

											switch ( $gameTextEntitiKey ) {

												case 'type';

													$userMessage['textEntitiesType'] = $gameTextEntitiValue;

													break;

												case 'offset':

													$userMessage['textEntitiesOffset'] = $gameTextEntitiValue;

													break;

												case 'length':

													$userMessage['textEntitiesLength'] = $gameTextEntitiValue;

													break;

												case 'url':

													$userMessage['textEntitiesUrl'] = $gameTextEntitiValue;

													break;

											}
										}

										break;

									case 'animation':

										foreach ( $data['message']['game']['animation'] as $gameAnimKey => $gameAnimValue ) {

											switch ( $gameAnimKey ) {

												case 'file_id':

													$userMessage['gameAnimFileId'] = $gameValue;

													break;

												case 'thumb':

													/*foreach ( $data['message']['game']['animation']['thumb'] as $animThumbKey => $animThumbValue ) {
													}*/

													// switch ()

													break;

												case 'file_name':

													$userMessage['gameAnimFileId'] = $gameValue;

													break;

												case 'mime_type':

													$userMessage['gameAnimFileId'] = $gameValue;

													break;

												case 'file_size':

													$userMessage['gameAnimFileSize'] = $gameValue;

													break;

											}

										}

										break;

								}

							}


							break;

						case 'photo':

							$userMessage['photo'] = $data['message']['photo'];

							break;

						case 'sticker':

							$userMessage['sticker'] = $data['message']['sticker'];

							break;

						case 'video':

							$userMessage['video'] = $data['message']['video'];


							break;

						case 'voice':

							$userMessage['voice'] = $data['message']['voice'];

							break;

						case 'video_note':

							$userMessage['videoNote'] = $data['message']['video_note'];

							break;

						case 'new_chat_members' :

							foreach ( $data['message']['new_chat_members'] as $newChatMemberKey => $newChatMemberValue ) {
								$userMessage = iterateDataBasic( $data['message']['new_chat_members'], 'user', 'newChatMember', $userMessage );
							}

							break; // it must be 2 array

						case 'caption':

							$userMessage['videoNoteFileId'] = $msValue;

							break;

						case 'contact':

							foreach ( $data['message']['contact'] as $contactKey => $contactValue ) {

								switch ( $contactKey ) {

									case 'phone_number':

										$userMessage['contactPhoneNumber'] = $contactValue;

										break;

									case 'first_name':

										$userMessage['contactFirstName'] = $contactValue;

										break;

									case 'last_name':

										$userMessage['contactLastName'] = $contactValue;

										break;

									case 'user_id':

										$userMessage['contactUserId'] = $contactValue;

										break;

								}

							}

							break;

						case 'location':

							$userMessage = iterateDataBasic( $data['message']['location'], 'location', 'location', $userMessage );

							break;

						case 'venue':

							foreach ( $data['message']['venue'] as $venueKey => $venueValue ) {

								switch ( $venueKey ) {

									case 'location':

										$userMessage = iterateDataBasic( $data['message']['venue']['location'], 'location', 'venueLocation', $userMessage );

										break;

									case 'title':

										$userMessage['venueTitle'] = $venueValue;

										break;

									case 'address':

										$userMessage['venueAddress'] = $venueValue;

										break;

									case 'foursquare_id':

										$userMessage['venueFoursquareId'] = $venueValue;

										break;

								}

							}

							break;

						case 'new_chat_member':

							$userMessage = iterateDataBasic( $data['message']['new_chat_member'], 'user', 'newChatMember', $userMessage );

							break;

						case 'left_chat_member':

							$userMessage = iterateDataBasic( $data['message']['left_chat_member'], 'user', 'leftChatMember', $userMessage );

							break;

						case 'new_chat_title':

							$userMessage['newChatTitle'] = $msValue;

							break;

						case 'new_chat_photo':


							break; // not handel

						case 'delete_chat_photo':

							$userMessage['deleteChatPhoto'] = $msValue;

							break;

						case 'group_chat_created':

							$userMessage['groupChatCreated'] = $msValue;

							break;

						case'supergroup_chat_created':

							$userMessage['superGroupChatCreated'] = $msValue;

							break;

						case'channel_chat_created':

							$userMessage['ChannelChatCreated'] = $msValue;

							break;

						case'migrate_to_chat_id':

							$userMessage['migrateToChatId'] = $msValue;

							break;

						case'migrate_from_chat_id':

							$userMessage['migrateFromChatId'] = $msValue;

							break;

						case'pinned_message': //not handel


							break;

						case'invoice':

							foreach ( $data['message']['invoice'] as $invoiceKey => $invoiceValue ) {

								switch ( $invoiceKey ) {

									case 'title':

										$userMessage['invoiceTitle'] = $invoiceValue;

										break;

									case 'description':

										$userMessage['invoiceDescription'] = $invoiceValue;

										break;

									case 'start_parameter':

										$userMessage['invoiceStartParameter'] = $invoiceValue;

										break;

									case 'currency':

										$userMessage['invoiceCurrency'] = $invoiceValue;

										break;

									case 'total_amount':

										$userMessage['invoiceTotalAmount'] = $invoiceValue;

										break;

								}

							}

							break;
					}
				}
			}
		}
	}

	return $userMessage;

}


/**
 *
 * This function give you array, that have callback_query
 * You can use it to get callback_data from inner keyboard
 *
 * attention: usage is optional
 *
 * @param $update
 *
 * @return array
 */

function callBackQuerySimplify( $update ) {

	$callBackQuery = array();

	if ( $update !== null ) {


		foreach ( $update as $updateKey => $updateValue ) {


			if ( $updateKey === 'update_id' ) {

				$callBackQuery['updateId'] = $updateValue;

			}

			if ( $updateKey === 'callback_query' ) {

				foreach ( $update['callback_query'] as $callBackKey => $callBackValue ) {

					switch ( $callBackKey ) {

						case 'id':

							$callBackQuery['callBackId'] = $callBackValue;

							break;

						case 'from':

							$callBackQuery = iterateDataBasic( $update['callback_query']['from'], 'user', 'callBackFrom', $callBackQuery );

							break;

						case 'message':

							//original message object
							$callBackQuery['callBackMessage'] = $update['callback_query']['message'];

							//some useful data

							$callBackQuery['callBackMsgId']            = $update['callback_query']['message']['message_id'];
							$callBackQuery['callBackMsgFromId']        = $update['callback_query']['message']['from']['id'];
							$callBackQuery['callBackMsgFromFirstName'] = $update['callback_query']['message']['from']['first_name'];
							$callBackQuery['callBackMsgFromUserName']  = $update['callback_query']['message']['from']['username'];

							$callBackQuery['callBackMsgChatId']        = $update['callback_query']['message']['chat']['id'];
							$callBackQuery['callBackMsgChatFirstName'] = $update['callback_query']['message']['chat']['first_name'];
							$callBackQuery['callBackMsgChatLastName']  = $update['callback_query']['message']['chat']['last_name'];
							$callBackQuery['callBackMsgChatUserName']  = $update['callback_query']['message']['chat']['username'];
							$callBackQuery['callBackMsgChatType']      = $update['callback_query']['message']['chat']['type'];

							$callBackQuery['callBackMsgDate'] = $update['callback_query']['message']['date'];
							$callBackQuery['callBackMsgText'] = $update['callback_query']['message']['text'];


							break;

						case 'inline_message_id':

							$callBackQuery['callBackQueryInlineMessageId'] = $callBackValue;

							break;

						case 'chat_instance':

							$callBackQuery['chatInstance'] = $callBackValue;

							break;

						case 'data':

							$callBackQuery['callBackData'] = $callBackValue;

							break;

						case 'game_short_name':

							$callBackQuery['callBackQueryGameShortName'] = $callBackValue;

							break;

					}

				}
			}
		}
	}

	return $callBackQuery;

}

/**
 * Send Message to user
 *
 * BOT_TOKEN: you must defined that in your bot php page like:
 *      define('BOT_TOKEN', 'YOUR TOKEN ID');
 *
 * @param $chatId
 * @param $message
 * @param $options
 *
 * @return mixed|null
 */

function sendMessage( $chatId, $message, $options = null ) {

	$url = API_URL . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode( $message );

	if ( $options != null ) {

		foreach ( $options as $key => $value ) {


			switch ( $key ) {

				case 'parse_mode':

					$url .= '&parse_mode=' . $value;

					break;

				case 'disable_web_page_preview':

					$url .= '&disable_web_page_preview=' . $value;

					break;

				case 'disable_notification':

					$url .= '&disable_notification=' . $value;

					break;

				case 'reply_to_message_id':

					$url .= '&reply_to_message_id=' . $value;

					break;

				case 'reply_markup':

					$url .= '&reply_markup=' . $value;

					break;
			}

		}
	}

	return simpleCurl( $url );

}

/**
 *  create curl
 * 
 * @param $url
 *
 * @return mixed|null
 *
 */
function simpleCurl( $url ) {

	$ch = curl_init();

	// 2. set the options, including the url
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_HEADER, 0 );

	// 3. execute and fetch the resulting HTML output
	$output = curl_exec( $ch );

	// 4. free up the curl handle
	curl_close( $ch );

	if ( $output === false ) {

		echo "cURL Error: " . curl_error( $ch );

		return null;

	} else {

		return $output;

	}

}

/**
 *
 * This function handel answerCallBackQuery
 *
 * @param $callBackId
 * @param $message
 *
 * @return mixed|null
 */
function answerCallBackQuery( $callBackId, $message = null ) {

	$url = API_URL . "/answerCallbackQuery?callback_query_id=" . $callBackId . "&text=" . $message;

	return simpleCurl( $url );


}


/**
 *
 * Create normal buttons
 *
 *  Just call the function and put the array on it, in array just write the key name's,
 *  for make new row just write '#newRow' mean keyboard new row and write your key name's for that
 *
 * @param $keys
 * @param bool $one_time_keyboard
 * @param bool $resize_keyboard
 * @param bool $selective
 *
 * @return string
 *
 */
function createButton( $keys, $one_time_keyboard = false, $resize_keyboard = true, $selective = true ) {


	$keyBoard    = array();
	$keyBoardRow = array();
	$text        = '';

	foreach ( $keys as $key => $value ) {

		// we need new row keyboard
		if ( $value === '#newRow' ) {

			array_push( $keyBoard, $keyBoardRow );
			$keyBoardRow = array();

		} else {

			// is that share phone button?
			if ( $key === 'request_contact' && $value === true ) {

				array_push( $keyBoardRow, array( 'text' => $text, 'request_contact' => $value ) );

				//is that share location button?
			} elseif ( $key === 'request_location' && $value === true ) {

				array_push( $keyBoardRow, array( 'text' => $text, 'request_location' => $value ) );

			} else {
				// is that the text of share phone number?
				if ( $key === 'textShareNumber' ) {

					$text = $value;
					//is that the text of share location button?
				} elseif ( $key === 'textShareLocation' ) {

					$text = $value;

				} else {

					// push key's in row
					array_push( $keyBoardRow, $value );

				}
			}
		}
	}
	array_push( $keyBoard, $keyBoardRow );

	$replyMarkup = array(
		'keyboard'          => $keyBoard,
		'one_time_keyboard' => $one_time_keyboard,
		'resize_keyboard'   => $resize_keyboard,
		'selective'         => $selective
	);

	return json_encode( $replyMarkup, true );

}


/**
 *  This function create inner key Board
 *  It Work look like createButton function
 *
 * @param $keys
 *
 * @return string
 *
 */
function createInnerButton( $keys ) {
	$inlineBoard       = array();
	$inlineKeyBoardRow = array();

	foreach ( $keys as $key => $value ) {

		if ( $value === '#newRow' ) {

			array_push( $inlineBoard, $inlineKeyBoardRow );
			$inlineKeyBoardRow = array();

		} else {

			//is that url button ?
			if ( substr( $value, 0, strpos( $value, "." ) ) === 'url' ) {

				array_push( $inlineKeyBoardRow, array(
					"text" => $key,
					"url"  => substr( $value, strpos( $value, "." ) + 1 )
				) );

				//is that callBack button?
			} elseif ( substr( $value, 0, strpos( $value, "." ) ) === 'callBack' ) {

				array_push( $inlineKeyBoardRow, array(
					"text"          => $key,
					"callback_data" => substr( $value, strpos( $value, "." ) + 1 )
				) );

				//is that switch to inline buttons
			} elseif ( substr( $value, 0, strpos( $value, "." ) ) === 'switch' ) {

				array_push( $inlineKeyBoardRow, array(
					"text"   => $key,
					"switch" => substr( $value, strpos( $value, "." ) + 1 )
				) );

			}


		}

	}

	array_push( $inlineBoard, $inlineKeyBoardRow );

	$inlineKeyBoard = array(
		"inline_keyboard" => $inlineBoard
	);

	return json_encode( $inlineKeyBoard );

}

/**
 *
 * This function send file to user
 * Just call it and pass an assosiative array with options such as,
 * Dont forget write the url and chat id and type in to array like :  chat_id => 'the id', type = 'photo'
 * Type mean what is that your file you want to send ? audio? photo ? ...
 *
 * @param $options
 *
 * @return bool|mixed
 * @throws Exception
 *
 */
function sendFile( $options ) {

	$typeSending = '';
	$data        = '';

	// need real path of your file
	$fileUrl = new CURLFile( realpath( $options['path_file'] ) );

	//what url must be ? and what is the options?
	switch ( $options['type'] ) {

		case 'photo':
			$typeSending = '/sendPhoto';
			break;

		case 'audio':
			$typeSending = '/sendAudio';
			break;

		case 'document':
			$typeSending = '/sendDocument';
			break;

		case 'sticker':
			$typeSending = '/sendSticker';
			break;

		case 'video':
			$typeSending = '/sendVideo';
			break;

		case 'voice':
			$typeSending = '/sendVoice';
			break;

		case 'video_note':
			$typeSending = '/sendVideoNote';
			break;

	}

	foreach ( $options as $key => $value ) {

		if ( $key !== 'path_file' ) {
			if ( $key === 'type' ) {
				$data[ $value ] = $fileUrl;
			} else {
				$data[ $key ] = $value;
			}
		}
	}

	$ch = curl_init( API_URL . $typeSending );
	curl_setopt( $ch, CURLOPT_HEADER, false );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

	//check information
	$response = curl_exec( $ch );

	if ( $response === false ) {
		$errno = curl_errno( $ch );
		$error = curl_error( $ch );
		error_log( "Curl returned error $errno: $error\n" );
		curl_close( $ch );

		return false;
	}

	$http_code = intval( curl_getinfo( $ch, CURLINFO_HTTP_CODE ) );
	curl_close( $ch );

	if ( $http_code >= 500 ) {
		// do not wat to DDOS server if something goes wrong
		sleep( 10 );

		return false;

	} else if ( $http_code != 200 ) {
		$response = json_decode( $response, true );
		error_log( "Request has failed with error {$response['error_code']}: {$response['description']}\n" );
		if ( $http_code == 401 ) {
			throw new Exception( 'Invalid access token provided' );
		}

		return false;

	} else {
		$response = json_decode( $response, true );
		if ( isset( $response['description'] ) ) {
			error_log( "Request was successfull: {$response['description']}\n" );
		}
		$response = $response['result'];
	}

	return $response;

}

/**
 *
 * This function help you to download Files
 *
 * @param $fileIds
 * @param $download_path
 *
 *
 * @return string
 */
function getFile( $fileIds, $download_path ) {

	switch ( $fileIds ) {

		case ( ! empty( $fileIds[3]['file_id'] ) ) :

			$dlUrl   = API_URL . "/getFile?file_id=" . $fileIds[3]['file_id'];
			$file_id = $fileIds[3]['file_id'];

			break;

		case ( ! empty( $fileIds[2]['file_id'] ) ):

			$dlUrl   = API_URL . "/getFile?file_id=" . $fileIds[2]['file_id'];
			$file_id = $fileIds[2]['file_id'];

			break;

		case ( ! empty( $fileIds[1]['file_id'] ) ):

			$dlUrl   = API_URL . "/getFile?file_id=" . $fileIds[1]['file_id'];
			$file_id = $fileIds[1]['file_id'];

			break;

		case ( ! empty( $fileIds[0]['file_id'] ) ):

			$dlUrl   = API_URL . "/getFile?file_id=" . $fileIds[0]['file_id'];
			$file_id = $fileIds[0]['file_id'];

			break;

		default:

			$dlUrl   = API_URL . "/getFile?file_id=" . $fileIds['file_id'];
			$file_id = $fileIds['file_id'];

			break;


	}

	$dlUrl = simpleCurl( $dlUrl );

	if ( $dlUrl !== null ) {

		$dlUrl = json_decode( $dlUrl, true );

	} else {

		return null;

	}


	if ( ! $dlUrl['result'] ) {
		exit;
	}

	$file = 'https://api.telegram.org/file/bot' . BOT_TOKEN . '/' . $dlUrl['result']['file_path'];

	if ( strpos( $dlUrl['result']['file_path'], 'stickers' ) !== false ) {

		//used file_id for name of the file
		$img = $download_path . '/' . $file_id . '.webp';

		$result = simpleCurl( $file );

		if ( $result !== null ) {

			file_put_contents( $img, $result );

		} else {

			return null;

		}

		return 1;

	} else {

		//used file_id for name of the file
		$img = $download_path . '/' . $file_id . '.' . substr( $dlUrl['result']['file_path'], strpos( $dlUrl['result']['file_path'], "." ) + 1 );

		$result = simpleCurl( $file );

		if ( $result !== null ) {

			file_put_contents( $img, $result );


		} else {

			return null;

		}

		return $file_id . '.' . substr( $dlUrl['result']['file_path'], strpos( $dlUrl['result']['file_path'], "." ) + 1 );

	}

}


/**
 *
 * create Data base connection
 *
 *
 */
function createDbConnection() {

	$host = 'localhost';
	$db   = 'darkoob2_robot_tutorial';
	$user = 'darkoob2_pouria';
	$pass = '-zBXYg;YMz^Y';

	$dsn = "mysql:host=$host;dbname=$db";
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];

	return new PDO( $dsn, $user, $pass, $opt );

}




