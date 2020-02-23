<?php
namespace SilverStripe\Lessons;

use PageController;

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;

class ArticlePageController extends PageController{

    private static $allowed_actions = [
        'CommentForm',
    ];

    public function CommentForm(){
        $form = Form::create(
            $this,
            __FUNCTION__,
            FieldList::create(
                TextField::create('Name',''),
                EmailField::create('Email',''),
                TextareaField::create('Comment','')

            ),
            FieldList::create(
                FormAction::create('handleComment','Post Comment')
                    ->setUseButtonTag(true)
                    ->addExtraClass('btn btn-default-color btn-lg')
            ),
            RequiredFields::create('Name','Email','Comment')
        )
            ->addExtraClass('form-style');

        foreach($form->Fields() as $field) {
            // var_dump( $field->Type() );
            $field->addExtraClass('form-group')
                ->setAttribute('placeholder', $field->getName().'*');

            if($field->Type() === 'textarea'){
                $field->setTemplate('MyCustomTextAreaField');
            } else {
                $field->setTemplate('MyCustomTextField');
            }

        }
        $data = $this->getRequest()->getSession()->get("FormData.{$form->getName()}.data");

        return $data ? $form->loadDataFrom($data)>setTemplate('CustomForm') : $form->setTemplate('CustomForm');
    }

    public function handleComment($data, $form){
        // $comment = ArticleComment::create();
        // $comment->Name = $data['Name'];
        // $comment->Email = $data['Email'];
        // $comment->Comment = $data['Comment'];
        // $comment->ArticlePageID = $this->ID;
        // $comment->write();
        //
        // $form->sessionMessage('Thanks for your comment!', 'good');
        //
        // return $this->redirectBack();

        $session = $this->getRequest()->getSession();
        $session->set("FormData.{$form->getName()}.data", $data);

        $existing = $this->Comments()->filter([
            'Comment' => $data['Comment']
        ]);

        if($existing->exists() && strlen($data['Comment']) > 20) {
            $form->sessionMessage('That comment already exists! Spammer!','bad');

            return $this->redirectBack();
        }

        $comment = ArticleComment::create();
        $comment->ArticlePageID = $this->ID;
        $form->saveInto($comment);
        $comment->write();

        $session->clear("FormData.{$form->getName()}.data");
        $form->sessionMessage('Thanks for your comment!','good');

        return $this->redirectBack();
    }

}
