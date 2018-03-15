
* [Darkoobweb.com](http://darkoobweb.com)
* *License.* GPL

## Summary

* A simple API to help you create your telegram bot faster and easier.
* This is some function's i use alot, and i want share them with you.

## Before use

1. Create your bot on botfather.
2. SSL certificate.
3. Set your webhook.

## Install

1. Put VSTBA.php on your host.
2. Create the main page for your bot.
3. Put the *require_once('vstba.php');* on the top of your bot page.
4. in the VSTBA.php put your token_id in *define('BOT_TOKEN', 'your token id');

## Get Data

* For get data from JSON you can use: 

  ``` 
  $update1 = file_get_contents("php://input");
  
  $update = json_decode($update1, TRUE);
  
  $chatId = $update['message']['chat']['id'];
  ```
  
* Or you can use *userMessage* and *getCallBackQuery* function to do it simpler:
    
    ```
    $message = userMessage($update);
    $callBackMessage = getCallBackQuery($update);
    $chatId = $message['chatId'];
    ```
    If this two function makes you confused, don't use them.
     
## Sending Message To User

* You can use *sendMessage* function, this function get 3 parameter: 
    1. chat id 
    2. message 
    3. options 
    
    options is an array, you can put something like parse_mode,... on it.
    [see this telegram api](https://core.telegram.org/bots/api#sendmessage)
    
* Some Examples:
    * send simple message:
    
    ```
    sendMessage($message['chatId'], 'How can i help you?');    
    ```
    also you can get chat id like this:
    
    ```
        sendMessage($update['message']['chat']['id'], 'How can i help you?'); 
    ```
    * send message whit keyBoard:
    
    ```
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
                            'about us'
                        ))
                )
            
            );

     ```

   I'll show you later how can create button.
   
   * send message whit some HTML tag:
       
       ```
             sendMessage($message['chatId'],
                  "Finaly you can use it like this:\n
                  
                  <pre> sendMessage(message['chatId'], 'hello', array('parse_mode'=>'HTML'))</pre>",
                  
                  array(
                       
                        'parse_mode' => 'HTML'
                        
                        ));
 
   
        ```
        
## Create ReplyKeyboardMarkup

* You can use *createButton*, this function get 4 parameter, 3 of them is optional.
    
    1. keys
    2. on_time_keyboad
    3. resize_keyboard
    4. selective 
    
    keys is an array, you make it and just have the key name, for create new row just type #newRow.
    
    * example:
      
      ```
      createButton(
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
              'about us'
          ))
      
      ```
      
      how can create share phone number button? use *textShareNumber* for key and put any value you want to show the user, 
      then create another key *request_contact* and put the value *true* for it.
      
      ```
      createButton(
                array(
                        'nothing To do.',
                        'textShareNumber' => 'share your number',
                        'request_contact' => true,
                        'back'
      ))

      ```
      
      how can create share location button? create *textShareLocation* as key and put anything you want to show for user,
      then create another key *request_location* and put the value *true* for it. 
      
      ```
      createButton(
                array(
                        'nothing To do.',
                        'textShareNumber' => 'share your number',
                        'request_contact' => true,
                        '#newRow',
                        'textShareLocation' => 'share location',
                        'request_location' => true,
                        'back'
      ))

      ```
      
## Create InlineKeyboardMarkup

* You can use *createInnerButton* as you know telegram have 3 kind of this button,
   1. callBack button
   2. URL button
   3. switch to inline button
   
* example:

```
createInnerButton(array(
    'see call back json' => 'callBack.callBackJson',
    'share Phone number' => 'callBack.sharePhoneButton',
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

))

```

As you can see for create callBack button i just user *callBack* . and the call back id,
For URL button *url* . and the any url you want, for switch is just like this two.

## Handel Callback button

* Use *answerCallBackQuery* this function get 2 parameter first callBackId and second message, message is optional, message will be toast for user.
  
 * example:
 
 ```
 answerCallBackQuery($callBackMessage['callBackId'], 'this is jason 😎');
 ```
 also you can get callBackId like this:
 
 ```
 answerCallBackQuery($update['callback_query']['id'], 'this is jason 😎');
 ```
 
## Send File

* You can use *sendFile*, this function get 1 parameter, an array, on this array you must enter address of the file
    , chat id, and type of the file. other thing like caption is optional.
    
    * example:
         send Audio file:
        
        ```
        sendFile(array(
            'path_file' => 'audio/tiktak.MP3',
            'chat_id' => $callBackMessage['callBackMsgChatId'],
            'type' => 'audio',
            'caption' => 'send file method worked',
            'disable_notification' => false
        ));

        ```
        
         send Sticker:
        
        ```
        sendFile(array(
        
            'path_file' => 'sticker/sticker.webp',
            'chat_id' => $callBackMessage['callBackMsgChatId'],
            'type' => 'sticker',
            'caption' => 'I will kiss you.'
        
        ));

        ```
        
         send Document:
        
        ```
        sendFile(array(
        
            'path_file' => 'doc/Hello.txt',
            'chat_id' => $callBackMessage['callBackMsgChatId'],
            'type' => 'document',
            'caption' => 'Read Me Please.'
        
        ));

        ```
        
         send Video:
        
        ```
        sendFile(array(
        
            'path_file' => 'video/sample.mp4',
            'chat_id' => $callBackMessage['callBackMsgChatId'],
            'type' => 'video',
            'caption' => 'I am a video :)',
            'disable_notification' => true
        
        ));

        ```
        
         send picture:
        
        ```
        sendFile(array(
            'path_file' => 'pic/s2.jpg',
            'chat_id' => $callBackMessage['callBackMsgChatId'],
            'type' => 'photo',
            'caption' => 'I AM SAMURAI',
            'disable_notification' => false
        ));

        ```
        
## Get File 

* You can use *getFile*, this function get 2 parameter, first parameter is an array you receive in your json,
and second parameter is where you want to store files.
    * example:
    
         get picture:
        ```
        getFile($message['photo'], 'download/photo');
        ```
        for the first parameter you can do like this:
        
        ```
        getFile($update['message']['photo'], 'download/photo');
        ```
        
        get document:
        
        ```
        getFile($message['document'], 'download/doc');
        ```
        
         get sticker:
        
        ```
        getFile($message['sticker'], 'download/sticker');
        ```
        
         get Audio:
        ```
        getFile($message['audio'], 'download/audio');
        ```
        
    * File names are the id's file.
        
        
## Connect to mySql
        
* First you must go to VSTBA.php find  *createDbConnection* and enter your,
       Host, user, pass and data base name in $dbHost, $dbUser, $dbPass, $dbName,
       after that you can use $PDO = createDbConnection(); and you have object of pdo
    
## More examples

* you can join to this bot *@testPlaceBot* and test it.
* Also i put the source of this bot here *theBot.php* you can see and use it.

## Feel free to pull request
