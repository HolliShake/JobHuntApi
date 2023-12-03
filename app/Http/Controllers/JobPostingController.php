<?php

namespace App\Http\Controllers;

use App\Services\file_banner\IFileBannerService;
use App\Services\file_sample_photo\IFileSamplePhotoService;
use App\Services\job_posting\IJobPostingService;
use Illuminate\Support\Facades\Validator;

class JobPostingController extends ControllerBase
{
    function __construct(
        private IJobPostingService $jobPostingService,
        private IFileBannerService $fileBannerService,
        private IFileSamplePhotoService $fileSamplePhotoService,
    ) {
    }

    function getJobPostingByCompanyId($company_id) {
        return $this->ok($this->jobPostingService->getByCompanyId($company_id));
    }

    function createJobPosting() {
        $request = $this->getValue();
        $validator = Validator::make($request, $this->createRules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $jobPosting = $this->jobPostingService->create([
            'date_posted' => request()->input('date_posted'),
            'adtype_id' => request()->input('adtype_id'),
            'position_id' => request()->input('position_id'),
            'is_hide_company_info' => $request['is_hide_company_info'],
            'is_hidden' => $request['is_hidden'],
            'paid' => $request['paid'],
            'description' => $request['description'],
        ]);

        if (!$jobPosting) {
            return $this->badRequest('');
        }

        $bannerResult = null;

        if (request()->file('banner')) {
            $banner = request()->file('banner');
            $banner_file_name = time() . '_' . $banner->getClientOriginalName();
            $bresult = $banner->storeAs('uploads', $banner_file_name, 'public');

            if ($bresult) {
                $bannerResult = $this->fileBannerService->create([
                    'job_posting_id' => $jobPosting->id,
                    'file_name' => $banner_file_name,
                ]);
            }
        }

        $file_images = [
            'file-1',
            'file-2',
            'file-3',
            'file-4',
        ];

        $present_files = [];

        foreach ($file_images as $file) {
            $image = request()->file($file);
            if (!$image) {
                continue;
            }

            $image_file_name = time() . '_' . $image->getClientOriginalName();
            $iresult = $image->storeAs('uploads', $image_file_name, 'public');

            if ($iresult) {
                array_push($present_files, [
                    'job_posting_id' => $jobPosting->id,
                    'file_name' => $image_file_name,
                ]);
            }
        }

        if (count($present_files) > 0) {
            $result = $this->fileSamplePhotoService->createAll($present_files);

            if (!$result) {
                return $this->badRequest('Sample Images not inserted!');
            }
        }

        // InserImages
        return $this->created($this->jobPostingService->getByIdWithRelation($jobPosting['id']));
    }

    function updateJobPosting($job_posting_id) {
        $request = $this->getValue();
        $validator = Validator::make($request, $this->updateRules());

        if ($validator->fails()) {
            return $this->badRequest([ 'errors' => $validator->errors() ]);
        }

        $old = $this->jobPostingService->getById($job_posting_id);

        if (!$old) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $old, $request);
        $uresult = $this->jobPostingService->update($updated);

        if (!$uresult) {
            return $this->badRequest('');
        }

        $bannerResult = null;

        if (request()->file('banner')) {
            $banner = request()->file('banner');
            $banner_file_name = time() . '_' . $banner->getClientOriginalName();
            $bresult = $banner->storeAs('uploads', $banner_file_name, 'public');

            if ($bresult) {
                $this->fileBannerService->deleteAllByJobPostingId($job_posting_id);
                $bannerResult = $this->fileBannerService->create([
                    'job_posting_id' => $job_posting_id,
                    'file_name' => $banner_file_name,
                ]);
            }
        }

        $file_images = [
            'file-1',
            'file-2',
            'file-3',
            'file-4',
        ];

        $present_files = [];

        foreach ($file_images as $file) {
            $image = request()->file($file);
            if (!$image) {
                continue;
            }

            $image_file_name = time() . '_' . $image->getClientOriginalName();
            $iresult = $image->storeAs('uploads', $image_file_name, 'public');

            if ($iresult) {
                array_push($present_files, [
                    'job_posting_id' => $job_posting_id,
                    'file_name' => $image_file_name,
                ]);
            }
        }

        if (count($present_files) > 0) {
            $this->fileSamplePhotoService->deleteAllByJobPostingId($job_posting_id);
            $result = $this->fileSamplePhotoService->createAll($present_files);

            if (!$result) {
                return $this->badRequest('Sample Images not inserted!');
            }
        }

        // InserImages
        return $this->ok($this->jobPostingService->getByIdWithRelation($old->id));
    }

    function deleteJobPosting($job_posting_id) {
        $jobPosting = $this->jobPostingService->getById($job_posting_id);

        if (!$jobPosting) {
            return $this->notFound('');
        }

        $del0 = $this->fileBannerService->deleteAllByJobPostingId($job_posting_id);
        $del1 = $this->fileSamplePhotoService->deleteAllByJobPostingId($job_posting_id);

        if (!($del0 || $del1)) {
            return $this->badRequest('Banner not deleted!');
        }

        $result = $this->jobPostingService->delete($jobPosting);

        return ($result)
            ? $this->noContent()
            : $this->badRequest('');
    }

    function updateJobPostingStatus($job_posting_id) {
        $jobPosting = $this->jobPostingService->getById($job_posting_id);

        if (!$jobPosting) {
            return $this->notFound('');
        }

        $updated = (object) array_merge((array) $jobPosting, request()->all());
        $uresult = $this->jobPostingService->update($updated);

        return ($uresult)
            ? $this->noContent()
            : $this->badRequest('');
    }

    function getValue() {
        return [
            ...(request()->all()),
            'is_hide_company_info' => (request()->input('is_hide_company_info')  === 'true') ? 1 : 0,
            'is_hidden' => (request()->input('is_hidden')  === 'true') ? 1 : 0,
            'paid' => (request()->input('paid')  === 'true') ? 1 : 0,
        ];
    }

    function createRules() {
        return [
            'adtype_id' => 'required|integer',
            'position_id' => 'required|integer',
            'is_hide_company_info' => 'required|boolean',
            'is_hidden' => 'required|boolean',
            'paid' => 'required|boolean',
            'description' => 'string|max:2048',
            'date_posted' => 'required|date',
            'banner' => 'required|mimes:jpg,png|max:10240', // 10mb
            'file-1' => 'mimes:jpg,png|max:10240', // 10mb
            'file-2' => 'mimes:jpg,png|max:10240', // 10mb
            'file-3' => 'mimes:jpg,png|max:10240', // 10mb
            'file-4' => 'mimes:jpg,png|max:10240', // 10mb
        ];
    }

    function updateRules() {
        return [
            'adtype_id' => 'required|integer',
            'position_id' => 'required|integer',
            'is_hide_company_info' => 'required|boolean',
            'is_hidden' => 'required|boolean',
            'paid' => 'required|boolean',
            'description' => 'string|max:2048',
            'date_posted' => 'required|date',
            'banner' => 'mimes:jpg,png|max:10240', // 10mb
            'file-1' => 'mimes:jpg,png|max:10240', // 10mb
            'file-2' => 'mimes:jpg,png|max:10240', // 10mb
            'file-3' => 'mimes:jpg,png|max:10240', // 10mb
            'file-4' => 'mimes:jpg,png|max:10240', // 10mb
        ];
    }

    //

    function getSampleFeaturedJobPosting() {
        return $this->ok($this->jobPostingService->getSampleFeaturedJobPosting());
    }
}
