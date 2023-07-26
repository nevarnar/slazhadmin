@extends('layouts.main')
@section('title', ' Reply Ticket')
@section('content')

<support-ticket-reply />
{{-- <div class="inner-main-container pb-12">
    <div class="mx-4 px-4" id="reply_ticket_box">
      <div class="mb-4">
        <p class="text-black text-lg primary-font block mb-1">Reply Ticket</p>
        <button type="button" class="primary-font block text-gray-600">
          <i class="fal fa-comment-lines mr-3"></i>TIck-0002
        </button>
      </div>

      <div>
        <div class="mb-3">
          <p class="text-base primary-font">Title</p>
          <span class="text-sm text-gray-500 primary-font">
            12:30
          </span>
        </div>
        <div class="mb-6">
          <p class="text-sm text-gray-500">
            Descisklfja
          </p>
        </div>
        <div class="px-28 py-28 bg-gray-400 relative w-0">
          <img
            class="h-full w-full absolute top-0 left-0"
            alt=""
          />
        </div>
        <hr class="mb-4 mt-6 h-0" />
      </div>

      <div>
        <div class="mb-3">
          <p class="text-sm text-gray-500">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat
          </p>
        </div>
        <div class="flex justify-between mb-3">
          <span class="text-sm text-gray-500"> 9:30 AM 10 May 2022 </span>
          <p class="text-sm text-black">latest reply by Admin</p>
        </div>
        <hr class="mb-6 mt-6 h-0" />
      </div>

      <div>
        <div class="mb-3">
          <p class="text-black text-lg primary-font">Reply Your Ticket</p>
        </div>
        <div class="mb-8">
          <label for="comment" class="text-base primary-font pb-3"
            >Comment</label
          >
          <input
            type="text"
            class="form-control block input-ui mt-3"
            id="comment"
            placeholder="Comment"
          />
        </div>
        <div class="mb-12">
          <label for="photo_upload" class="bg-white border py-2 px-4">
            Browse
            <input type="file" class="appearance-none hidden" />
          </label>
        </div>
        <div class="mb-4">
          <button type="button" class="primary-button px-12">Reply</button>

          <button type="button" id="ticket_btn" class="btn-clear px-3">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div> --}}
@endsection
