<?php

namespace App\Services\Journal;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Journal\JournalRepository;

class JournalServiceImplement extends Service implements JournalService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(JournalRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function sortByUserId()
  {
    DB::beginTransaction();
    try {
      $return = $this->mainRepository->sortByUserId();
    } catch (Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
    DB::commit();
    return $return;
  }

  public function getReadyPublishData()
  {
    DB::beginTransaction();
    try {
      $return = $this->mainRepository->getReadyPublishData();
    } catch (Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
    DB::commit();
    return $return;
  }

  public function handleUploadJournal($request)
  {
    DB::beginTransaction();
    try {
      // Manajamen file
      if ($request->file('file')) :
        $file = Storage::putFile('public/pdf/journals', $request->file('file'));
      endif;

      $validation = $request->validated();
      $validation['title'] = strtoupper($request->title);
      $validation['file'] = $file;
      $validation['excerpt'] = Str::limit(strip_tags($request->title), 30, '...');
      $validation['upload_year'] = $request->upload_year;
      $validation['user_id'] = me()->id;

      $return = $this->mainRepository->create($validation);
    } catch (Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
    DB::commit();
    return $return;
  }

  public function handleUpdateJournal($request, $journal)
  {
    DB::beginTransaction();
    try {
      // Manajamen file
      if ($request->file('file')) :
        if ($request->oldFile) :
          Storage::delete($journal->file);
        endif;
        $file = Storage::putFile('public/pdf/journals', $request->file('file'));
      else :
        $file = null;
      endif;

      $validation = $request->validated();
      $validation['file'] = $file;

      $return = $this->mainRepository->update($journal->id, $validation);
    } catch (Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
    DB::commit();
    return $return;
  }

  public function handleDeleteJournal($journal)
  {
    DB::beginTransaction();
    try {
      // Handle delete image.
      if ($journal->file) :
        Storage::delete($journal->file);
      endif;

      $return = $this->mainRepository->delete($journal->id);
    } catch (Exception $e) {
      DB::rollBack();
      Log::info($e->getMessage());
      throw new InvalidArgumentException(trans('session.log.error'));
    }
    DB::commit();
    return $return;
  }
}
