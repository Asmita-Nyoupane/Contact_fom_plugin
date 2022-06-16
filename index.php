
<?php
/**
 * Plugin Name:       Contact Form
 * Plugin URI:        https://www.wordpress.org
 * Description:       Simple contact form
 * Version:           1.0.0
 * Author:            Asmita Nyoupane
 * Author URI:        https://asmita.com/
 
 */


function contact_form_shortcode(){
    //creating a empty variable called as content
    $content ='';
    $content.='<h1 style ="text-align:center" > Contact Us </h1>';
    $content.='<form method="post" action="http://localhost/testsite/thank-you/" style="  background-color: lightgrey;
        width: 300px;
        padding: 50px;
        margin: 20px;">';
// for full name
    $content.= '<label for ="your_name" >Full Name    :  </label> ' ;
    $content.='<input type ="text"name="your_name" placeholder="Enter your full name" style="height:30px;width:100%;"/> <br>';
//for email

    $content.= '<label for ="your_email for contact">Email    :  </label>';
    $content.='<input type ="email" name="your_email" style="height:30px;width:100%;" placeholder="name@example.com"/> <br>';
    // for phone number
    $content.='<label for="phone number">Phone number :    </label>';
    $content.='<input type="tel"  name="phone_number"  style="height:30px;width:100%;" placeholder="Enter your phone number"> </br>';

// for comments
    $content.= '<label for ="your_comments "> Comment   :   </label> ';
    $content.='<textarea name ="your_comment" style="height:30px;width:100%;"  placeholder ="Enter your opinion"></textarea> <br>';


    $content.='<input type="submit" style="height:30px;width:50%; background-color:#033b44;color:white;" name ="form_submit" value="Submit">';

    $content.='</form>';
    return $content;
}
//creating a shortcode for plugin
add_shortcode('contact_form', 'contact_form_shortcode');

function set_html_mail_content_type() {
    return 'text/html';
}

function form_info_capture(){
    global $post;
    if(array_key_exists('form_submit',$_POST))
    {
        add_filter( 'wp_mail_content_type', 'set_html_mail_content_type' );

        $to="itenthusiastic37@gmail.com";
        $subject="contact form submission";
        $message='';
        $message.='Name :        '.$_POST['your_name'].'</br>';
        $message.='Email :       '.$_POST['your_email'].'</br>';
        $message.='Phone Number: '.$_POST['phone_number'].'</br>';
        $message.='Comment   :   '.$_POST['your_comment'].'</br>';

        
        wp_mail($to, $subject, $message);

         remove_filter( 'wp_mail_content_type', 'set_html_mail_content_type' );

        $time=current_time('mysql');
        $data = array(
            'comment_post_ID'=>$post->ID,
            'comment_content'=>$message,
            'comment_author_IP'=>$_SERVER['REMOTE_ADDR'],
            'comment_date'=>$time,
            'comment_approve'=> 1,
        );
    
        wp_insert_comment($data);
    }

}
add_action('wp_head', 'form_info_capture');
?>
