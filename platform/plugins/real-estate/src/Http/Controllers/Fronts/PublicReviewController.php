<?php

namespace Botble\RealEstate\Http\Controllers\Fronts;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\RealEstate\Repositories\Interfaces\ReviewInterface;
use Botble\RealEstate\Http\Requests\ReviewRequest;
use Botble\RealEstate\Models\ReviewMeta;

class PublicReviewController
{

    /**
     * @var ReviewInterface
     */
    protected $reviewRepository;

   

    /**
     * PublicReviewController constructor.
     * @param ReviewInterface $reviewRepository
     */
    public function __construct(
        ReviewInterface $reviewRepository
    ) {
        $this->reviewRepository = $reviewRepository;
    }


    /**
     * @param ReviewRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function postCreateReview(ReviewRequest $request, BaseHttpResponse $response)
    {
        $exists = $this->reviewRepository->count([
            'account_id' => auth('account')->id(),
            'reviewable_id'  => $request->input('reviewable_id'),
            'reviewable_type'  => $request->input('reviewable_type'),
        ]);

        $setting = \Botble\Setting\Models\Setting::where('key', 'real_estate_review_fields')->first();
        $settingReviewFields = json_decode($setting->value);

        $getReviewMeta = \Botble\RealEstate\Models\ReviewMeta::where('review_id', $request->input('review_id'))->get();
        
         if ($exists > 0) {
             return $response
                 ->setError()
                 ->setMessage(__('You have reviewed this product already!'));
         }

        if ($request->input('edit') == 'yes') {
            foreach ($getReviewMeta as $key => $value) {
                $updateReview = \Botble\RealEstate\Models\ReviewMeta::find($value->id);

                foreach ($settingReviewFields as $k => $v) {
                    if ($v[0]->value == $updateReview->key) {
                        $updateReview->value = $request->input('meta')[$updateReview->key];
                        $updateReview->save();       
                    }
                }
            }   

            $getMyReview            = \Botble\RealEstate\Models\Review::find($request->input('review_id'));
            $getMyReview->star      = $request->input('star');
            $getMyReview->comment   = $request->input('comment');
            $getMyReview->save();
            
        }else{
            $request->merge(['account_id' => auth('account')->id()]);

            $review = $this->reviewRepository->createOrUpdate($request->input());
            
            foreach ($request->input('meta') as $key => $value) {
                ReviewMeta::setMeta($key, $value, $review->id);
            }
        }

        if ($request->input('edit') == 'yes') {
            return $response->setNextUrl(route('public.account.myReview'))->setMessage(__('Edited review successfully!'));
        }else{
            return $response->setMessage(__('Added review successfully!'));
        }

    }

    /**
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function getDeleteReview($id, BaseHttpResponse $response)
    {
        $review = $this->reviewRepository->findOrFail($id);

        if (auth()->check() || (auth('account')->check() && auth('account')->id() == $review->account_id)) {

            $review->meta()->delete();
            $this->reviewRepository->delete($review);

            return $response->setMessage(__('Deleted review successfully!'));
        }

        abort(401);
    }
}
