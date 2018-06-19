<?php 
import('lib.pkp.classes.plugins.GenericPlugin'); 
import('lib.pkp.classes.form.validation.FormValidator');

class ReviewersPlugin extends GenericPlugin { 

    private $reviewers_fields = array();
    private $param_names = array('FirstName','LastName','Email','Preferred','Institution');


    function register($category, $path, $mainContextId = null) { 
        $success = parent::register($category, $path, $mainContextId);
        if ($success && $this->getEnabled($mainContextId)) { 

            if(!$this->reviewers_fields){
                foreach($this->param_names as $param_name){
                    for ($i = 1; $i < 4; $i++) {
                        $key_name = 'reviewer'.$i.$param_name;
                        $this->reviewers_fields[] = $key_name;
                    }
                }
            }

            HookRegistry::register('Templates::Submission::SubmissionMetadataForm::AdditionalMetadata', array($this, 'renderReviewersForm'));

            HookRegistry::register('submissionsubmitstep3form::initdata', array($this, 'initReviewersData'));

            HookRegistry::register('submissionsubmitstep3form::readuservars', array($this, 'readReviewersUserVars'));

            HookRegistry::register('submissionsubmitstep3form::execute', array($this, 'reviewersExecute'));

            HookRegistry::register('SubmissionSubmitStep3Formform::Constructor', array($this, 'reviewersCheck'));

            HookRegistry::register('articledao::getAdditionalFieldNames', array($this, 'addReviewersFieldNames'));

            HookRegistry::register('LoadComponentHandler', array($this, 'setupGridHandler'));


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
        $smarty->assign('reviewerFieldNames', $this->reviewers_fields);
        $output .= $smarty->fetch($this->getTemplatePath() . 'reviewers.tpl');
        return false;        
    }


/**
     * Inits the form with article data
     */
    function reviewersInitData($hookName, $params) {
        $form =& $params[0];
        $article = $form->submission;
        foreach($this->reviewers_fields as $r_field){
            $rf = $article->getData($r_field);
            $form->setData($r_field, $rf);
        }
        return false;
    }


/**
     * add to input data (from form)
     */
    function readReviewersUserVars($hookName, $params) {
        $userVars =& $params[1];
        foreach($this->reviewers_fields as $r_field){
            $userVars[] = $r_field;
        }
        return false;        
    }


/**
     * Add projectID element to the article
     */
    function addReviewersFieldNames($hookName, $params) {
        $fields =& $params[1];
        foreach($this->reviewers_fields as $r_field){
            $fields[] = $r_field;
        }
        return false;
    }


/**
     * Set article projectID
     */
    function reviewersExecute($hookName, $params) {
        $form =& $params[0];
        $article =& $params[1];
        foreach($this->reviewers_fields as $r_field){
            $rf = $form->getData($r_field);
            $article->setData($r_field, $rf);
        }
        return false;    
    }


    /**
     * Permit requests to the custom block grid handler
     * @param $hookName string The name of the hook being invoked
     * @param $args array The parameters to the invoked hook
     */
    function setupGridHandler($hookName, $params) {
        $component =& $params[0];
        if ($component == 'plugins.generic.reviewers.controllers.grid.ReviewersGridHandler') {
            import($component);
            $className = array_pop(explode('.', $component));
            $className::setPlugin($this);
            return true;
        }
        return false;
    }

} 
?>