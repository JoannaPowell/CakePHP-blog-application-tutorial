<?php
/**
 * Post inherits from AppModel so uses the pre-programmed features
 * provided by CakePHP for the business logic.
 *
 * It ensures that a post is unable to have a blank title or body
 * field.
 */

class Post extends AppModel {

  public $validate = array(
        'title' => array(
            'rule' => 'notBlank'
        ),
        'body' => array(
            'rule' => 'notBlank'
        )
    );
}
