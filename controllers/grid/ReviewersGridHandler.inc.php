<?php

/**
 *
 */

//import('lib.pkp.classes.controllers.grid.users.reviewer.PKPReviewerGridHandler');
import ('lib.pkp.classes.controllers.grid.GridHandler');
// import reviewer grid specific classes
import('plugins.generic.reviewers.controllers.grid.TrialGridCellProvider');
import('plugins.generic.reviewers.controllers.grid.TrialGridRow');



class ReviewersGridHandler extends GridHandler {
	/** @var ReviewersPlugin The reviewers plugin */
	static $plugin;

	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();

		$this->addRoleAssignment(
			array(ROLE_ID_MANAGER, ROLE_ID_SUB_EDITOR),'fetchGrid');

	}

	/**
	 * Set the translator plugin.
	 * @param $plugin StaticPagesPlugin
	 */
	static function setPlugin($plugin) {
		self::$plugin = $plugin;
	}


	function initialize($request) {
		parent::initialize($request);

		// Load submission-specific translations
		AppLocale::requireComponents(
			LOCALE_COMPONENT_PKP_SUBMISSION,
			LOCALE_COMPONENT_PKP_MANAGER,
			LOCALE_COMPONENT_PKP_USER,
			LOCALE_COMPONENT_PKP_EDITOR,
			LOCALE_COMPONENT_PKP_REVIEWER,
			LOCALE_COMPONENT_APP_EDITOR
		);

		$this->setTitle('user.role.reviewers');

		// Grid actions
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		$router = $request->getRouter();
		$actionArgs = array_merge($this->getRequestArgs(), array('selectionType' => REVIEWER_SELECT_ADVANCED_SEARCH));
		$this->addAction(
			new LinkAction(
				'addReviewer',
				new AjaxModal(
					$router->url($request, null, null, 'showReviewerForm', null, $actionArgs),
					__('editor.submission.addReviewer'),
					'modal_add_user'
					),
				__('editor.submission.addReviewer'),
				'add_user'
				)
			);

		// Columns
		$cellProvider = new ReviewerGridCellProvider();
		$this->addColumn(
			new GridColumn(
				'name',
				'user.name',
				null,
				null,
				$cellProvider
			)
		);

		// Add a column for the status of the review.
		$this->addColumn(
			new GridColumn(
				'considered',
				'common.status',
				null,
				null,
				$cellProvider,
				array('anyhtml' => true)
			)
		);

		// Add a column for the status of the review.
		$this->addColumn(
			new GridColumn(
				'actions',
				'grid.columns.actions',
				null,
				null,
				$cellProvider
			)
		);
	}


}

?>
