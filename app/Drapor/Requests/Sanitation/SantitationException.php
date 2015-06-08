<?php namespace App\Drapor\Requests\Sanitation;

	use Illuminate\Support\MessageBag;
	use Illuminate\Contracts\Support\MessageProvider;

	class SanitationException extends \Exception implements MessageProvider {

		/**
		 * @var MessageBag
		 */
		protected $errors;

		/**
		 * @param string     $message
		 * @param MessageBag $errors
		 */
		public function __construct($message, MessageBag $errors)
		{
			$this->errors = $errors;

			parent::__construct($message);
		}

		/**
		 * Get form validation errors
		 *
		 * @return MessageBag
		 */
		public function getMessageBag()
		{
			return $this->errors;
		}

	}
