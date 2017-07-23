<?php
/**
 * Created by IntelliJ IDEA.
 * User: Pouria
 * Date: 6/28/2017
 * Time: 9:57 PM
 */

require_once('vstba.php');

$update1 = file_get_contents("php://input");
$update = json_decode($update1, TRUE);

if (!$update) {
    // receive wrong update, must not happen
    exit;
}

// for get chat id, text, contact and etc.
$message = userMessage($update);
$callBackMessage = getCallBackQuery($update);

if (array_key_exists('messageText', $message)) {


    switch ($message['messageText']) {

        case '/start':


            sendMessage($message['chatId'],
                "Hello, my name is VSTBA 🙃 \n That mean Very Simple Telegram Bot API 😊. \n How can i help you 🤔 ?",
                array(
                    'reply_markup' => createButton(
                        array(
                            'How can i use ?',
                            'How can i sendMessage ?',
                            'How can i create Keyboard?',
                            '#newRow',
                            'How can i create inlineKeyboard?',
                            'How can i Send File ?',
                            'How can i get File ?',
                            '#newRow',
                            'show inline keyboard.',
                            'how can i get chat id etc...',
                            'about us'
                        ))
                )

            );
            break;

        case 'How can i use ?':

            sendMessage($message['chatId'],

                "After download me, include me in you php page, \n
            Then in top of me (vstba.php) create \n
            <pre>define('BOT_TOKEN', 'Your token id'); 
            define('API_URL', 'https://api.telegram.org/bot' . BOT_TOKEN); </pre> \n
            Now in your page write this codes: 
            <pre>anyVariableName = file_get_contents(\"php://input\"); 
            anyVariableName = json_decode(anyVariableName, TRUE); </pre>

           <pre> if (!anyVariableName) { 
            // receive wrong update, must not happen 
                exit; 
            } </pre>

            // for get chat id, text, contact and etc. \n
           <pre> message = userMessage($update); 
            callBackMessage = getCallBackQuery($update);</pre> 
            Just this.
            ",

                array('parse_mode' => 'HTML'));

            break;

        case 'How can i sendMessage ?':

            sendMessage($message['chatId'],
                "For send message to user, you can use sendMessage function \n
            This function get 3 property, first chat id, second the message you want send, and third options.",
                null);

            sendMessage($message['chatId'],
                "You can get chat id like this, message['chatId'],\n
            your message anything you want can type. \n
            options, this is associative array and the keys are sendMessage parameters in https://core.telegram.org/bots/api#sendmessage",
                null);

            sendMessage($message['chatId'],
                "Finaly you can use it like this:\n
           <pre> sendMessage(message['chatId'], 'hello', array('parse_mode'=>'HTML'))</pre>",
                array('parse_mode' => 'HTML'));

            break;

        case 'How can i create Keyboard?':

            sendMessage($message['chatId'],

                "For create keyBoard use createButton, \n
            This is an simple array for create new row in you key bord just type #newRow on array. \n
            Then put this in to ke option sendMessage function",
                null);

            sendMessage($message['chatId'],

                "Finaly you can create button like this: \n
            <pre>sendMessage(message['chatId'], 
            'anythig you want', array('reply_markup' => createButton(
                    array(
                        'key one',
                        'key two',
                        'key three',
                        '#newRow',
                        '4',
                        '5',
                        '6'
                    ))));</pre>",
                array(
                    'parse_mode' => 'HTML'
                ));


            break;

        case 'How can i create inlineKeyboard?':

            sendMessage($message['chatId'],
                "For create inlineKeyboard, use createInnerButton. \n
            This function get an associative array, the keys is name of the keyboard \n
            And value can be for callback_data (example: callBack.keyName), Url (example: url.KeyName) or switch (example: switch.keyName), for create new row use #newRow as value .",
                null);

            sendMessage($message['chatId'],
                "So you code look like this: 
            <pre>sendMessage(message['chatId'], 'something', array(
            'reply_markup' => createInnerButton(
                      array(
                     'see call back json' => 'callBack.h',
                     'share Phone number' => 'callBack.yes',
                     'w' => '#newRow',
                     'send me Music' => 'callBack.sendMusic',
                     'ww' => '#newRow',
                     'send sticker' => 'callBack.stickerSend',
                     'send doc' => 'callBack.sendMeDoc',
                     'a' => '#newRow',
                     'send video' => 'callBack.sendVideo',
                     'send noteVideo' => 'callBack.videoNote'))</pre>",
                array('parse_mode' => 'HTML'));

            break;

        case 'show inline keyboard.' :
            sendMessage($message['chatId'],
                'Select any key you want',

                array(

                    'reply_markup' => createInnerButton(array(
                        'see call back json' => 'callBack.callBackJson',
                        'share buttons' => 'callBack.shareButtons',
                        'a' => '#newRow',
                        'send me Music' => 'callBack.sendMusic',
                        'b' => '#newRow',
                        'send Sticker' => 'callBack.stickerSend',
                        'send Doc' => 'callBack.sendMeDoc',
                        'c' => '#newRow',
                        'send Video' => 'callBack.sendVideo',
                        'send NoteVideo' => 'callBack.videoNote',
                        'send Photo' => 'callBack.sendPhoto',
                        'url Button' => 'url.http://darkoobweb.com'

                    )),
                )
            );

            break;

        case 'How can i Send File ?' :

            sendMessage($message['chatId'],
                "For sending any file to user you can use, sendFile function \n
            This function get an associative array, \n
            The key's is: path_file, chat_id, type, caption, disable_notification \n
            type is: photo, audio, document, sticker, video, voice, video_note",
                null);

            sendMessage($message['chatId'], "Your code look like this: \n
        <pre>sendFile(array(
            'path_file' => 'pic/s2.jpg',
            'chat_id' => message['chatId'],
            'type' => 'photo',
            'caption' => 'I AM SAMURAI',
            'disable_notification' => false
        ));</pre>
        
        ", array('parse_mode' => 'HTML'));


            break;

        case 'How can i get File ?':

            sendMessage($message['chatId'],
                "If you want get file from user you can use getFile function
             This function can get any file.
             this function get two parameter first file id's and second path to save file in there", null);

            sendMessage($message['chatId'], "Your code must look like this:
        <pre>getFile(message['photo'], 'download/photo');</pre>", array('parse_mode' => 'HTML'));

            break;

        case 'back':

            sendMessage($message['chatId'],
                'Hello Again...',
                array('reply_markup' => createButton(
                    array(
                        'How can i use ?',
                        'How can i sendMessage ?',
                        'How can i create Keyboard?',
                        '#newRow',
                        'How can i create inlineKeyboard?',
                        'How can i Send File ?',
                        'How can i get File ?',
                        '#newRow',
                        'show inline keyboard.'
                    ))));

            break;

        case 'about us':

            sendMessage($message['chatId'], "http://darkoobweb.com \n https://darkoobweb.ir \n Pouria Parhmi & Hooman Moein", null);

            break;

        case 'how can i get chat id etc...':

            sendMessage($message['chatId'],

                "update_id =>  message['updateId'] \n" .

                "message_id => message['messageId'] \n" .
                "message_date =>  message['messageDate'] \n" .
                "message_text =>  message['messageText'] \n" .

                "message_from_id =>  message['fromId'] \n" .
                "message_from_first_name => message['fromFirstName'] \n" .
                "message_from_last_name => message['fromLastName'] \n" .
                "message_from_username => message['fromUserName'] \n" .
                "message_from_langCode => message['fromLangCode'] \n" .

                "message_chat_id => message['chatId'] \n" .
                "message_chat_type => message['chatType'] \n" .
                "message_chat_title => message['chatTitle'] \n" .
                "message_chat_user_name => message['chatUsername'] \n" .
                "message_chat_first_name => message['chatFirstName'] \n" .
                "message_chat_last_name => message['chatLastName'] \n" .
                "message_chat_all_members_are_administrators => message['chatAllMembersAreAdmin'] \n" .
                "message_chat_photo => message['chatPhoto'] \n" .
                "message_chat_description => message['chatDescription'] \n" .
                "message_chat_invite_link => message['chatInviteLine'] \n" .
                "message_forward_from_id => message['forwardFromId'] \n" .
                "message_forward_from_first_name => message['forwardFromFirstName'] \n" .
                "message_forward_from_last_name => message['forwardFromLastName'] \n" .
                "message_forward_from_user_name => message['forwardFromUserName'] \n" .
                "message_forward_from_lang_code => message['forwardFromLangCode'] \n" .
                "message_forward_date =>  message['forwardDate'] \n" .
                "message_edit_date =>  message['editDate'] \n" .
                "message_entities_type => message['entitiesType'] \n" .
                "message_edit_date_offset => message['entitiesOffset'] \n" .
                "message_edit_date_length => message['entitiesLength'] \n" .
                "message_edit_date_url =>  message['entitiesUrl'] \n" .
                "message_audio =>  message['audio']  you receive an array\n" .
                "message_document =>  message['document']  you receive an array\n" .
                "message_audio =>  message['photo']  you receive an array\n" .
                "message_video =>  message['video']  you receive an array\n" .
                "message_voice => message['voice']  you receive an array\n" .
                "message_video_note => message['videoNote']  you receive an array\n" .
                "message_video_note => message['videoNote']  you receive an array\n" .
                "message_caption => message['caption']  \n" .
                "message_contact_phone_number => message['contactPhoneNumber'] \n" .
                "message_caption_first_name => message['contactFirstName']  \n" .
                "message_caption_last_name => message['contentLastName']  \n" .
                "message_caption_user_id => message['contactUserId']  \n"


            );

            //Simple iteration for message Array
            $string = '';
            foreach ($message as $msKey => $msValue) {

                $string .= $msKey . " => " . $msValue . "\n";

            }

            sendMessage($message['chatId'], $string);

            break;

        default:

            sendMessage($message['chatId'], 'How can i help you?' . $update1);

            break;

    }

} elseif (array_key_exists('contactPhoneNumber', $message)) {

    //is that a phone number?

    sendMessage($message['chatId'], 'we got number');


    //is that photo?
} elseif (array_key_exists('photo', $message)) {

    getFile($message['photo'], 'download/photo');
    sendMessage($message['chatId'], 'I got a photo ');

} elseif (array_key_exists('document', $message)) {

    //is that document ?

    getFile($message['document'], 'download/doc');
    sendMessage($message['chatId'], 'I got a document ');


} elseif (array_key_exists('sticker', $message)) {

    //is that sticker ?

    getFile($message['sticker'], 'download/sticker');
    sendMessage($message['chatId'], 'I got a sticker ');

} elseif (array_key_exists('audio', $message)) {

    //is that audio ?

    getFile($message['audio'], 'download/audio');
    sendMessage($message['chatId'], 'I got a audio ');

}


//have i callBackQuery ?
if (array_key_exists('callBackData', $callBackMessage)) {


    switch ($callBackMessage['callBackData']) {

        case 'callBackJson':

            answerCallBackQuery($callBackMessage['callBackId'], 'this is jason 😎');

            sendMessage($callBackMessage['callBackMsgChatId'],

                'callBackId: ' . $callBackMessage['callBackId'] . "\n" .
                'chatInstance: ' . $callBackMessage['chatInstance'] . "\n" .
                'callBackData: ' . $callBackMessage['callBackData'] . "\n" .

                'fromId: ' . $callBackMessage['callBackFromId'] . "\n" .
                'fromFirstName: ' . $callBackMessage['callBackFromFirstName'] . "\n" .
                'fromLastName: ' . $callBackMessage['callBackFromLastName'] . "\n" .
                'fromUserName: ' . $callBackMessage['callBackFromUserName'] . "\n" .
                'fromLanguageCode: ' . $callBackMessage['callBackFromLangCode'] . "\n" .

                'messageId: ' . $callBackMessage['callBackMsgId'] . "\n" .
                'messageFromId: ' . $callBackMessage['callBackMsgFromId'] . "\n" .
                'messageFromFirstName: ' . $callBackMessage['callBackMsgFromFirstName'] . "\n" .
                'messageFromUserName: ' . $callBackMessage['callBackMsgFromUserName'] . "\n" .

                'chatId: ' . $callBackMessage['callBackMsgChatId'] . "\n" .
                'chatFirstName: ' . $callBackMessage['callBackMsgChatFirstName'] . "\n" .
                'chatLastName: ' . $callBackMessage['callBackMsgChatLastName'] . "\n" .
                'chatUserName: ' . $callBackMessage['callBackMsgChatUserName'] . "\n" .
                'chatType: ' . $callBackMessage['callBackMsgChatType'] . "\n" .

                'messageDate: ' . $callBackMessage['callBackMsgDate'] . "\n" .
                'messageText: ' . $callBackMessage['callBackMsgText']

                , null);

            break;

        case 'shareButtons':

            answerCallBackQuery($callBackMessage['callBackId']);
            sendMessage($callBackMessage['callBackMsgChatId'],
                'press the share button 👇🏻.',
                array(

                    'reply_markup' => createButton(array(
                        'nothing To do.',
                        'textShareNumber' => 'share your number',
                        'request_contact' => true,
                        '#newRow',
                        'textShareLocation' => 'share location',
                        'request_location' => true,
                        'back'
                    ))
                )
            );

            break;

        case 'sendMusic':

            answerCallBackQuery($callBackMessage['callBackId'], 'wow The music 🕺🏻🎷🥁🎉⏯');
            sendFile(array(
                'path_file' => 'audio/tiktak.MP3',
                'chat_id' => $callBackMessage['callBackMsgChatId'],
                'type' => 'audio',
                'caption' => 'send file method worked',
                'disable_notification' => false
            ));

            break;

        case 'stickerSend':

            answerCallBackQuery($callBackMessage['callBackId']);
            sendFile(array(

                'path_file' => 'sticker/sticker.webp',
                'chat_id' => $callBackMessage['callBackMsgChatId'],
                'type' => 'sticker',
                'caption' => 'I will kiss you.'

            ));
            break;

        case 'sendMeDoc':

            answerCallBackQuery($callBackMessage['callBackId']);
            sendFile(array(

                'path_file' => 'doc/Hello.txt',
                'chat_id' => $callBackMessage['callBackMsgChatId'],
                'type' => 'document',
                'caption' => 'Read Me Please.'

            ));
            break;

        case 'sendVideo':

            answerCallBackQuery($callBackMessage['callBackId']);
            sendFile(array(

                'path_file' => 'video/sample.mp4',
                'chat_id' => $callBackMessage['callBackMsgChatId'],
                'type' => 'video',
                'caption' => 'I am a video :)',
                'disable_notification' => true

            ));

            break;

        case 'videoNote':

            answerCallBackQuery($callBackMessage['callBackId']);
            sendFile(array(

                'path_file' => 'video/onemunet.mp4',
                'chat_id' => $callBackMessage['callBackMsgChatId'],
                'type' => 'video',
                'caption' => 'I am a video :)',
                'disable_notification' => true

            ));

            break;

        case 'sendPhoto':

            answerCallBackQuery($callBackMessage['callBackId'], 'please w8');
            sendFile(array(
                'path_file' => 'pic/s2.jpg',
                'chat_id' => $callBackMessage['callBackMsgChatId'],
                'type' => 'photo',
                'caption' => 'I AM SAMURAI',
                'disable_notification' => false
            ));

            break;

    }
}