<?php namespace App\Drapor\Requests\Transformers;

/*
 * Why do we use a Transformer?
 * For clear concise business logic. This is a hub to edit
 * how and what is returned by the API.
 */
abstract class Transformer{

    protected $iteration;
    protected $length;
    protected $willEmbed;
    protected $embeds;

	public function transformCollection(array $items)
	{
        //$this->length = count($items);
		$map =  array_map([$this, 'transform'], $items);

        /*
        if($this->willEmbed){
            foreach($this->embeds as $embed){
                $map[$embed] = $items[0][$embed];
            }
        }*/

        return $map;
	}

	public abstract function transform($item);

	public function embedCourse($course){

		$output = [
			'id'          => (Int)$course['id'],
			'title'       => $course['title'],
            'subtitle'    => $course['subtitle'],
			'intro'       => $course['intro_video'],
			'description' => $course['description'],
            'thumbnail'   => $course['thumbnail'],
			'category' => [
				'id'   => (Int)$course['category']['id'],
				'name' => $course['category']['name'],
			],
			'user'     => $this->embedUser($course['user']),
            'price'    => $course['price'],
            'privacy'  => $course['privacy']
		];

        if(array_key_exists('reviews',$course)){
            $output['reviews'] = $this->getReviews($course['reviews']);
        }
        if(array_key_exists('students',$course)){
            $output['students'] = count($course['students']);
        }
        if(array_key_exists('sections',$course)){
            $output['sections'] = $this->getSections($course['sections']);
        }

        return $output;
	}

    public function embedVideo($video){
        return [
            'id'          => (Int)$video['id'],
            'course_id'   => (Int)$video['course_id'],
            'section_id'  => (Int)$video['section_id'],
            'title'       => $video['name'],
            'description' => $video['description'],
            'url'         => $video['mediaUrl'],
            'number'      => (Int)$video['number'],
            'status'      => $video['status'],
            'thumbnail'   => $video['thumbnail']
        ];
    }

    public function embedSection($section){

        $content = [
            'id'          => $section['id'],
            'course_id'   => $section['course_id'],
            'number'      => $section['number'],
            'title'       => $section['title'],
            'description' => $section['description']
        ];

        if (array_key_exists('videos', $section) && (count($section['videos']) > 0)) {
            $content['videos'] = $this->getVideos($section['videos']);
        }
        return $content;
    }
	/**
	 * @param $user
	 *
	 * @return array
	 */
	public function embedUser( $user ) {

        $userArr = [
                'id'    => (Int)$user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'profile' => [
                    'first_name'    => $user['profile']['first_name'],
                    'last_name'     => $user['profile']['last_name'],
                    'bio'           => $user['profile']['bio'],
                    'avatar'        => $user['profile']['avatar'],
                    'headline'      => $user['profile']['headline'],
                    'is_instructor' => (Int)$user['profile']['is_instructor'],
                    'website'       => $user['profile']['website'],
                    'twitter'       => $user['profile']['twitter']
                ],
                'subscription_id' => (Int)$user['subscription_id']
            ];

            if (array_key_exists('billing', $user)) {
                $userArr['billing'] = $this->getBilling($user['billing']);
            }

            if(array_key_exists('group',$user)){
                $userArr['group'] = [
                    'name' => $user['group']['name']
                ];
            }

            if(array_key_exists('courses',$user)){
                $userArr['courses'] = array_fetch($user['courses'],'course_id');
            }
            if(array_key_exists('student',$user)){
                $userArr['student'] = array_fetch($user['student'],'course_id');
            }

		return $userArr;
	}

	/**
	 * @param array $billing
	 * @return array
	 */
	public function getBilling($billing){
		return $billing;
	}

	/**
	 * @param $reviews
	 * @return array
	 */
	public function getReviews($reviews)
	{
		$collection = [];
		foreach ((array)$reviews as $review) {
			$collection[] = [
				'title'  => $review['title'],
				'body'   => $review['body'],
				'rating' => $review['rating'],
				'user'   => $this->embedUser($review['user']),
			];
		}
		return $collection;
	}

	/**
	 * @param  array $sections
	 * @return array
	 */
	public function getSections( $sections ) {
		    $output = [];

            foreach ((array)$sections as $section) {
                $output[] = $this->embedSection($section);
            }

		return $output;
	}

	/**
	 * @param  array $videos
	 * @return array $collection
	 */
	public function getVideos($videos){

		$collection = [];
		foreach((array)$videos as $video){
			$collection[] = $this->embedVideo($video);
		}
		return $collection;
	}
}