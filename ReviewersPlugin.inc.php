<?php 
import('lib.pkp.classes.plugins.GenericPlugin'); 
import('lib.pkp.classes.form.validation.FormValidator');

class ReviewersPlugin extends GenericPlugin { 

    function register($category, $path, $mainContextId = null) { 
        $success = parent::register($category, $path, $mainContextId);
        if ($success && $this->getEnabled($mainContextId)) { 

            HookRegistry::register('Templates::Submission::SubmissionMetadataForm::AdditionalMetadata', array($this, 'renderReviewersForm'));

            HookRegistry::register('submissionsubmitstep3form::initdata', array($this, 'initReviewersData'));

            HookRegistry::register('submissionsubmitstep3form::readuservars', array($this, 'readReviewersUserVars'));

            HookRegistry::register('submissionsubmitstep3form::execute', array($this, 'reviewersExecute'));

            HookRegistry::register('SubmissionSubmitStep3Formform::Constructor', array($this, 'reviewersCheck'));

            HookRegistry::register('articledao::getAdditionalFieldNames', array($this, 'addReviewersFieldNames'));


            return true; 
        } 
        return false; 
    }  



    function getName() { 
        return 'ReviewersPlugin'; 
    } 
    function getDisplayName() { 
        return 'Reviewers Plugin'; 
    } 
    function getDescription() { 
        return 'Add preferred reviewers to a submission.'; 
    } 

    /**
     * Set the enabled/disabled state of this plugin
     */
    function setEnabled($enabled) {
        parent::setEnabled($enabled);
        return false;
    }



    /**
     * Insert new field into author metadata submission form (submission step 3) and metadata form
     */


    function renderReviewersForm($hookName, $params){
        $smarty =& $params[1];
        $output =& $params[2];
        $output .= $smarty->fetch($this->getTemplatePath() . 'reviewers.tpl');
        return false;        
    }


/**
     * Inits the form with article data
     */
    function reviewersInitData($hookName, $params) {
        $form =& $params[0];
        $article = $form->submission;
        $reviewer1FirstName = $article->getData('reviewer1FirstName');
        $form->setData('reviewer1FirstName', $reviewer1FirstName);
        return false;
    }


/**
     * add to input data (from form)
     */
    function readReviewersUserVars($hookName, $params) {
        $userVars =& $params[1];
        $userVars[] = 'reviewer1FirstName';
        return false;
    }


/**
     * Add projectID element to the article
     */
    function addReviewersFieldNames($hookName, $params) {
        $fields =& $params[1];
        $fields[] = 'reviewer1FirstName';
        return false;
    }


/**
     * Set article projectID
     */
    function reviewersExecute($hookName, $params) {
        $form =& $params[0];
        $article =& $params[1];
        $rev1name = $form->getData('reviewer1FirstName');
        $article->setData('reviewer1FirstName', $rev1name);
        return false;    }


/**
     * Add check/validation for the projectID field (= 6 numbers) on form instantiation
     */
    function reviewersCheck($hookName, $params) {
        // $form =& $params[0];
        // if (get_class($form) == 'SubmissionSubmitStep3Form'){
        //     $form->addCheck(new FormValidator($this, 'reviewer1FirstName', 'required', 'author.submit.form.reviewerFirstNameRequired'));
        // }
        return false;
    }    



    // function addFormChecks($hookName, $args){
    //     $reviewersMinRequired = 3;
    //     $form = $args[0];
    //     for ($i=1; $i <= $reviewersMinRequired; $i++) {
    //         $form->addCheck(new FormValidator($this, 'reviewer'.$i.'FirstName', 'required', 'author.submit.form.reviewerFirstNameRequired'));
    //         $form->addCheck(new FormValidator($this, 'reviewer'.$i.'LastName', 'required', 'author.submit.form.reviewerLastNameRequired'));
    //         $form->addCheck(new FormValidator($this, 'reviewer'.$i.'Institution', 'required', 'author.submit.form.reviewerInstitutionRequired'));
    //         $form->addCheck(new FormValidator($this, 'reviewer'.$i.'Email', 'required', 'author.submit.form.reviewerEmailRequired'));
    //     }
    //         $form->addCheck(new FormValidator($this, 'commentsToEditor', 'required', 'author.submit.form.coverLetterRequired'));
    // }

    // /**
    //  * Add preferred reviewer info to the article
    //  */

    // function manageReviewers($hookName, $args) { 
    //     $param_names = array('FirstName','LastName','Email','Preferred','Institution');
    //     foreach($param_names as $param_name){
    //         for ($i = 1; $i < 7; $i++) {
    //             $key_name = 'reviewer'.$i.$param_name;
    //             if($hookName == 'articledao::getLocaleFieldNames'){
    //                 $args[0]->_data[$key_name] = $args[0]->article->getData($key_name);
    //                 //following openaire with hook name, it was 'articledao::getLocaleFieldNames'
    //             }elseif ($hookName == 'submissionsubmitstep1form::execute' 
    //                 || $hookName == 'submissionsubmitstep1form::readuservars') {
    //                 $args[1][] = $key_name;
    //             }
    //         }
    //     }
    //     return false; 
    // }   

} 
?>