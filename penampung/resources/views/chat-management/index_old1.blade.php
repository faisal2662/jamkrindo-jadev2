@extends('layouts.main')
@section('style')
    {{-- <style>
        #conversation {
            height: 500px;
        }

        .scrollable-container::-webkit-scrollbar-thumb {
            background-color: #457B9D;
            border-radius: 10px;
        }

        .scrollable-container::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F1FAEE;
        }

        .scrollable-container::-webkit-scrollbar {
            width: 5px;
            background-color: #F5F5F5;
        }

        .bg-conversation {
            background-color: #457B9D;
            border-radius: 10px;
            color: white
        }


        .bg-conversation a {

            color: white;
        }


        .list-message a {
            color: black;
            /* color: #d4d3d3; */
        }

        .list-message:hover {
            background-color: #8aadc2;
            border-radius: 10px;

        }

        #toast {
            visibility: hidden;
            min-width: 50px;
            margin-left: -125px;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            right: 30px;
            top: 80px;
            font-size: 17px;
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }

            to {
                top: 80px;
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                top: 80px;
                opacity: 1;
            }

            to {
                top: 0;
                opacity: 0;
            }
        }

        .attachment-preview-container {
            margin: 10px 0;
        }

        .attachment-preview {
            display: inline-block;
            vertical-align: top;
            margin-right: 10px;
            margin-bottom: 10px;
            text-align: center;
        }

        .attachment-preview img {
            max-width: 80px;
            border-radius: 4px;
        }

        .attachment-preview .doc-icon {
            font-size: 40px;
            color: #3498db;
        }

        .attachment-preview p {
            font-size: 10px;
            word-wrap: break-word;
            max-width: 80px;
        }
    </style> --}}
    {{-- <style>
        .fa-2x {
            font-size: 1.5em;
        }

        .app {
            position: relative;
            overflow: hidden;
            top: 19px;
            height: calc(100% - 38px);
            margin: auto;
            padding: 0;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
        }

        .app-one {
            background-color: #f7f7f7;
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .06), 0 2px 5px 0 rgba(0, 0, 0, .2);
        }

        .side {
            padding: 0;
            margin: 0;
            height: 100%;
        }

        .side-one {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            z-index: 1;
            position: relative;
            display: block;
            top: 0;
        }

        .side-two {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
            z-index: 2;
            position: relative;
            top: -100%;
            left: -100%;
            -webkit-transition: left 0.3s ease;
            transition: left 0.3s ease;

        }


        .heading {
            padding: 10px 16px 10px 15px;
            margin: 0;
            height: 60px;
            width: 100%;
            background-color: #eee;
            z-index: 1000;
        }

        .heading-avatar {
            padding: 0;
            cursor: pointer;

        }

        .heading-avatar-icon img {
            border-radius: 50%;
            height: 40px;
            width: 40px;
        }

        .heading-name {
            padding: 0 !important;
            cursor: pointer;
        }

        .heading-name-meta {
            font-weight: 700;
            font-size: 100%;
            padding: 5px;
            padding-bottom: 0;
            text-align: left;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #000;
            display: block;
        }

        .heading-online {
            display: none;
            padding: 0 5px;
            font-size: 12px;
            color: #93918f;
        }

        .heading-compose {
            padding: 0;
        }

        .heading-compose i {
            text-align: center;
            padding: 5px;
            color: #93918f;
            cursor: pointer;
        }

        .heading-dot {
            padding: 0;
            margin-left: 10px;
        }

        .heading-dot i {
            text-align: right;
            padding: 5px;
            color: #93918f;
            cursor: pointer;
        }

        .searchBox {
            padding: 0 !important;
            margin: 0 !important;
            height: 60px;
            width: 100%;
        }

        .searchBox-inner {
            height: 100%;
            width: 100%;
            padding: 10px !important;
            background-color: #fbfbfb;
        }


        /*#searchBox-inner input {
                  box-shadow: none;
                }*/

        .searchBox-inner input:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }

        .sideBar {
            padding: 0 !important;
            margin: 0 !important;
            background-color: #fff;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 120px);
        }

        .sideBar-body {
            position: relative;
            padding: 10px !important;
            border-bottom: 1px solid #f7f7f7;
            height: 72px;
            margin: 0 !important;
            cursor: pointer;
        }

        .sideBar-body:hover {
            background-color: #f2f2f2;
        }

        .sideBar-avatar {
            text-align: center;
            padding: 0 !important;
        }

        .avatar-icon img {
            border-radius: 50%;
            height: 49px;
            width: 49px;
        }

        .sideBar-main {
            padding: 0 !important;
        }

        .sideBar-main .row {
            padding: 0 !important;
            margin: 0 !important;
        }

        .sideBar-name {
            padding: 10px !important;
        }

        .name-meta {
            font-size: 100%;
            padding: 1% !important;
            text-align: left;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #000;
        }

        .sideBar-time {
            padding: 10px !important;
        }

        .time-meta {
            text-align: right;
            font-size: 12px;
            padding: 1% !important;
            color: rgba(0, 0, 0, .4);
            vertical-align: baseline;
        }

        /*New Message*/

        .newMessage {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
            position: relative;
            left: -100%;
        }

        .newMessage-heading {
            padding: 10px 16px 10px 15px !important;
            margin: 0 !important;
            height: 100px;
            width: 100%;
            background-color: #00bfa5;
            z-index: 1001;
        }

        .newMessage-main {
            padding: 10px 16px 0 15px !important;
            margin: 0 !important;
            height: 60px;
            margin-top: 30px !important;
            width: 100%;
            z-index: 1001;
            color: #fff;
        }

        .newMessage-title {
            font-size: 18px;
            font-weight: 700;
            padding: 10px 5px !important;
        }

        .newMessage-back {
            text-align: center;
            vertical-align: baseline;
            padding: 12px 5px !important;
            display: block;
            cursor: pointer;
        }

        .newMessage-back i {
            margin: auto !important;
        }

        .composeBox {
            padding: 0 !important;
            margin: 0 !important;
            height: 60px;
            width: 100%;
        }

        .composeBox-inner {
            height: 100%;
            width: 100%;
            padding: 10px !important;
            background-color: #fbfbfb;
        }

        .composeBox-inner input:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }

        .compose-sideBar {
            padding: 0 !important;
            margin: 0 !important;
            background-color: #fff;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 160px);
        }

        /*Conversation*/

        .conversation {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
            /*width: 100%;*/
            border-left: 1px solid rgba(0, 0, 0, .08);
            /*overflow-y: auto;*/
        }

        .message {
            padding: 0 !important;
            margin: 0 !important;

            background-size: cover;
            overflow-y: auto;
            border: 1px solid #f7f7f7;
            height: calc(100% - 120px);
        }

        .message-previous {
            margin: 0 !important;
            padding: 0 !important;
            height: auto;
            width: 100%;
        }

        .previous {
            font-size: 15px;
            text-align: center;
            padding: 10px !important;
            cursor: pointer;
        }

        .previous a {
            text-decoration: none;
            font-weight: 700;
        }

        .message-body {
            margin: 0 !important;
            padding: 0 !important;
            width: auto;
            height: auto;
        }

        .message-main-receiver {
            /*padding: 10px 20px;*/
            max-width: 60%;
        }

        .message-main-sender {
            padding: 3px 20px !important;
            margin-left: 40% !important;
            max-width: 60%;
        }

        .message-text {
            margin: 0 !important;
            padding: 5px !important;
            word-wrap: break-word;
            font-weight: 200;
            font-size: 14px;
            padding-bottom: 0 !important;
        }

        .message-time {
            margin: 0 !important;
            margin-left: 50px !important;
            font-size: 12px;
            text-align: right;
            color: #9a9a9a;

        }

        .receiver {
            width: auto !important;
            padding: 4px 10px 7px !important;
            border-radius: 10px 10px 10px 0;
            background: #ffffff;
            font-size: 12px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            word-wrap: break-word;
            display: inline-block;
        }

        .sender {
            float: right;
            width: auto !important;
            background: #dcf8c6;
            border-radius: 10px 10px 0 10px;
            padding: 4px 10px 7px !important;
            font-size: 12px;
            text-shadow: 0 1px 1px rgba(0, 0, 0, .2);
            display: inline-block;
            word-wrap: break-word;
        }


        /*Reply*/

        .reply {
            height: 60px;
            width: 100%;
            background-color: #f5f1ee;
            padding: 10px 5px 10px 5px !important;
            margin: 0 !important;
            z-index: 1000;
        }

        .reply-emojis {
            padding: 5px !important;
        }

        .reply-emojis i {
            text-align: center;
            padding: 5px 5px 5px 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-recording {
            padding: 5px !important;
        }

        .reply-recording i {
            text-align: center;
            padding: 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-send {
            padding: 5px !important;
        }

        .reply-send i {
            text-align: center;
            padding: 5px !important;
            color: #93918f;
            cursor: pointer;
        }

        .reply-main {
            padding: 2px 5px !important;
        }

        .reply-main textarea {
            width: 100%;
            resize: none;
            overflow: hidden;
            padding: 5px !important;
            outline: none;
            border: none;
            text-indent: 5px;
            box-shadow: none;
            height: 100%;
            font-size: 16px;
        }

        .reply-main textarea:focus {
            outline: none;
            border: none;
            text-indent: 5px;
            box-shadow: none;
        }

        @media screen and (max-width: 700px) {
            .app {
                top: 0;
                height: 100%;
            }

            .heading {
                height: 70px;
                background-color: #009688;
            }

            .fa-2x {
                font-size: 2.3em !important;
            }

            .heading-avatar {
                padding: 0 !important;
            }

            .heading-avatar-icon img {
                height: 50px;
                width: 50px;
            }

            .heading-compose {
                padding: 5px !important;
            }

            .heading-compose i {
                color: #fff;
                cursor: pointer;
            }

            .heading-dot {
                padding: 5px !important;
                margin-left: 10px !important;
            }

            .heading-dot i {
                color: #fff;
                cursor: pointer;
            }

            .sideBar {
                height: calc(100% - 130px);
            }

            .sideBar-body {
                height: 80px;
            }

            .sideBar-avatar {
                text-align: left;
                padding: 0 8px !important;
            }

            .avatar-icon img {
                height: 55px;
                width: 55px;
            }

            .sideBar-main {
                padding: 0 !important;
            }

            .sideBar-main .row {
                padding: 0 !important;
                margin: 0 !important;
            }

            .sideBar-name {
                padding: 10px 5px !important;
            }

            .name-meta {
                font-size: 16px;
                padding: 5% !important;
            }

            .sideBar-time {
                padding: 10px !important;
            }

            .time-meta {
                text-align: right;
                font-size: 14px;
                padding: 4% !important;
                color: rgba(0, 0, 0, .4);
                vertical-align: baseline;
            }

            /*Conversation*/
            .conversation {
                padding: 0 !important;
                margin: 0 !important;
                height: 100%;
                /*width: 100%;*/
                border-left: 1px solid rgba(0, 0, 0, .08);
                /*overflow-y: auto;*/
            }

            .message {
                height: calc(100% - 140px);
            }

            .reply {
                height: 70px;
            }

            .reply-emojis {
                padding: 5px 0 !important;
            }

            .reply-emojis i {
                padding: 5px 2px !important;
                font-size: 1.8em !important;
            }

            .reply-main {
                padding: 2px 8px !important;
            }

            .reply-main textarea {
                padding: 8px !important;
                font-size: 18px;
            }

            .reply-recording {
                padding: 5px 0 !important;
            }

            .reply-recording i {
                padding: 5px 0 !important;
                font-size: 1.8em !important;
            }

            .reply-send {
                padding: 5px 0 !important;
            }

            .reply-send i {
                padding: 5px 2px 5px 0 !important;
                font-size: 1.8em !important;
            }
        }
    </style> --}}
    <style>
        .card {
            background: #fff;
            transition: .5s;
            border: 0;
            margin-bottom: 30px;
            border-radius: .55rem;
            position: relative;
            width: 100%;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
        }

        #toast {
            visibility: hidden;
            min-width: 50px;
            margin-left: -125px;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            right: 30px;
            top: 80px;
            font-size: 17px;
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }

            to {
                top: 80px;
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                top: 80px;
                opacity: 1;
            }

            to {
                top: 0;
                opacity: 0;
            }
        }

        .chat-app .people-list {
            width: 280px;
            position: absolute;
            left: 0;
            top: 0;
            padding: 20px;
            z-index: 7
        }

        .chat-app .chat {
            margin-left: 280px;
            border-left: 1px solid #eaeaea
        }

        .people-list {
            -moz-transition: .5s;
            -o-transition: .5s;
            -webkit-transition: .5s;
            transition: .5s
        }

        .people-list .chat-list li {
            padding: 10px 15px;
            list-style: none;
            border-radius: 3px
        }

        .scrollable-container::-webkit-scrollbar-thumb {
            background-color: #457B9D;
            border-radius: 10px;
        }

        .scrollable-container::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            background-color: #F1FAEE;
        }

        .scrollable-container::-webkit-scrollbar {
            width: 5px;
            background-color: #F5F5F5;
        }


        .people-list .chat-list li:hover {
            background: #efefef;
            cursor: pointer
        }

        .people-list .chat-list li.active {
            background: #efefef
        }

        .people-list .chat-list li .name {
            font-size: 15px
        }

        .people-list .chat-list img {
            width: 45px;
            border-radius: 50%
        }

        .people-list img {
            float: left;
            border-radius: 50%
        }

        .people-list .about {
            float: left;
            padding-left: 8px
        }

        .people-list .status {
            color: #999;
            font-size: 13px
        }

        .chat .chat-header {
            padding: 15px 20px;
            border-bottom: 2px solid #f4f7f6;
            background-color: #f1f1f1;
        }

        .chat .chat-header img {
            float: left;
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px
        }

        .chat .chat-history {
            padding: 20px;
            border-bottom: 2px solid #fff
        }

        .chat .chat-history ul {
            padding: 0
        }

        .chat .chat-history ul li {
            list-style: none;
            margin-bottom: 30px
        }

        /*
                                                                                    .chat .chat-history ul li:last-child {
                                                                                        margin-bottom: 0px
                                                                                    } */

        .chat .chat-history .message-data {
            margin-bottom: 15px
        }

        .chat .chat-history .message-data img {
            border-radius: 40px;
            width: 40px
        }

        .chat .chat-history .message-data-time {
            color: #434651;
            padding-left: 6px
        }

        .chat .chat-history .message {
            color: #444;
            padding: 18px 20px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 7px;
            display: inline-block;
            position: relative
        }

        /* .chat .chat-history .message:after {
                                                                                            bottom: 100%;
                                                                                            left: 7%;
                                                                                            border: solid transparent;
                                                                                            content: " ";
                                                                                            height: 0;
                                                                                            width: 0;
                                                                                            position: absolute;
                                                                                            pointer-events: none;
                                                                                            border-bottom-color: #fff;
                                                                                            border-width: 10px;
                                                                                            margin-left: -10px
                                                                                        } */

        .chat .chat-history .my-message {
            background: #efefef;
        }

        /* .chat .chat-history .my-message:after {
                                                                                            bottom: 100%;
                                                                                            left: 30px;
                                                                                            border: solid transparent;
                                                                                            content: " ";
                                                                                            height: 0;
                                                                                            width: 0;
                                                                                            position: absolute;
                                                                                            pointer-events: none;
                                                                                            /* border-bottom-color: #efefef;
                                                                                            border-width: 10px;
                                                                                            margin-left: -10px
                                                                                        } */

        .chat .chat-history .other-message {
            background: #dcf8c6;
            text-align: right
        }

        /* .chat .chat-history .other-message:after {
                                                                                                                                                                                                                                                                                                                                                                                    border-bottom-color: #e8f1f3;
                                                                                                                                                                                                                                                                                                                                                                                    left: 93%
                                                                                                                                                                                                                                                                                                                                                                                } */

        .chat .chat-message {
            padding: 20px;
            background-color: #f1f1f1;
        }

        .online,
        .offline,
        .me {
            margin-right: 2px;
            font-size: 8px;
            vertical-align: middle
        }

        .online {
            color: #86c541
        }

        .offline {
            color: #e47297
        }

        .me {
            color: #1d8ecd
        }

        .float-right {
            float: right
        }

        /* .clearfix:after {
                                                                                        visibility: hidden;
                                                                                        display: block;
                                                                                        font-size: 0;
                                                                                        content: " yhj";
                                                                                        clear: both;
                                                                                        height: 0
                                                                                    } */

        #sendMessage:hover {
            cursor: pointer;
        }

        @media only screen and (max-width: 767px) {
            .chat-app .people-list {
                height: 465px;
                width: 100%;
                overflow-x: auto;
                background: #fff;
                left: -400px;
                display: none
            }

            .chat-app .people-list.open {
                left: 0
            }

            .chat-app .chat {
                margin: 0
            }

            .chat-app .chat .chat-header {
                border-radius: 0.55rem 0.55rem 0 0
            }

            .chat-app .chat-history {
                height: 300px;
                overflow-x: auto
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .chat-app .chat-list {
                height: 650px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: 600px;
                overflow-x: auto
            }
        }

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
            .chat-app .chat-list {
                height: 480px;
                overflow-x: auto
            }

            .chat-app .chat-history {
                height: calc(100vh - 350px);
                overflow-x: auto
            }
        }

        /* #scrollToBottom {
                                                                                                        position: fixed;
                                                                                                        bottom: 20px;
                                                                                                        right: 20px;
                                                                                                        z-index: 1000;
                                                                                                    } */
    </style>
@stop
@section('main')
    {{-- <section style="">
        <div class=" py-3">
            <div id="toast">
                <div class="alert alert-primary" role="alert">
                    <i class="bi bi-bell"></i> Masuk :
                    <span class="name fw-bold"></span>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12 col">
                    <input type="hidden" name="" id="currentConversationId">
                    <div class="card" id="chat3" style="border-radius: 10px; ">
                        <div class="card-body rounded" style="background-color:#1D3557">

                            <div class="row mt-3 ">
                                <div class="col-md-6 col-lg-5 col-xl-4  mb-md-0">

                                    <div class="p-3 scrollable-container " id="conversation"
                                        style="background-color: #ececec;">

                                        <div class="input-group rounded mb-3">
                                            <input type="search" class="form-control rounded" placeholder="Search"
                                                aria-label="Search" aria-describedby="search-addon" />
                                            <span class=" text-white input-group-text border-0"
                                                style="background-color:#457B9D;" id="search-addon">
                                                <i class="bi bi-search"></i>
                                            </span>
                                        </div>

                                        <div data-mdb-perfect-scrollbar-init style="position: relative;overflow-y:auto;">
                                            <ul class="list-unstyled mb-0" id="conversationList">


                                            </ul>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6 col-lg-7 col-xl-8  pt-3">
                                    <div class="header-chat">
                                        <div class="row bg-white rounded-4">
                                            <div class="col my-1">
                                                <img src="{{ asset('assets/img/person.png') }}" width="35px"
                                                    alt="" class="float-start mt-1">
                                               
                                                <div class="row"><span class="fw-bold me-2" id="nama-title"></span>
                                                </div>
                                                <div class="row"><span class="" id="cabang-title"></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3 pe-3 scrollable-container" data-mdb-perfect-scrollbar-init
                                        style=" position: relative; height: 400px;overflow-y: auto;" id="box-message">

                                        <div class="attachment-preview-container"></div>
                                    </div>


                                    <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                                        <div class="btn-group dropup">
                                            <span class="btn " type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-paperclip text-white fw-3 fs-4"></i>
                                            </span>
                                            <ul class="dropdown-menu">
                                                <li><span class="ms-3"><label for="document"><i
                                                                class="bi bi-file-earmark"></i> Dokumen</label><input
                                                            type="file" name="document" accept=".pdf, .doc, .docx, .xlsx"
                                                            id="document" style="display: none"></span>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><span class="ms-3"><label for="gambar"><i
                                                                class="bi bi-file-earmark-image"></i> Gambar</label><input
                                                            type="file" name="gambar" id="gambar"
                                                            accept=".jpg, .jpeg, .png, .PNG, .webp"
                                                            style="display: none"></span>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><span class="ms-3"><label for="video"> <i
                                                                class="bi bi-play-circle"></i> Video</label><input
                                                            type="file" name="video" id="video" accept=".mp4"
                                                            style="display: none"></span></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <button onclick="close()" onclick="" id="close" style="border:none;"
                                                    class=" float-end"><i class="bi bi-x"></i></button>
                                            </ul>
                                        </div>
                                        <input type="text" class="form-control " id="messageInput"
                                            placeholder="Type message">
                                        <button onclick="btn()" class=" fs-5 text-white"
                                            style="background:none;border:none;" id="sendMessage"><i
                                                class="bi bi-send"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <audio id="notificationSound" src="{{ asset('assets/notif/notif.mp3') }}" preload="auto"></audio>

        </div>
    </section> --}}
    <section>
        <div class="container">
            <div id="toast">

                <div class="alert alert-primary" role="alert">
                    <i class="bi bi-bell"></i> Masuk :
                    <span class="name-from fw-bold"></span>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card chat-app">
                        <div id="plist" class="people-list">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>

                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                            <ul class="list-unstyled scrollable-container chat-list  mt-2 mb-0" id="conversationList"
                                style=" position: relative; height: 400px;overflow-y: auto;">


                            </ul>
                        </div>
                        <div class="chat">
                            <div class="chat-header clearfix">
                                <div class="row">
                                    <div class="col-lg-6">

                                        <div id="img-customer">
                                        </div>
                                        <div class="chat-about">
                                            <h6 class="m-b-0 " id="nama-title"></h6>
                                            <small id="cabang-title"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 hidden-sm ">
                                        <div class="float-end">
                                            {{-- <button id="closeChat" class="btn btn-outline-secondary btn-sm">Close
                                                Chat</button> --}}
                                            {{-- <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm"><i
                                                    class="fa fa-image"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-info btn-sm"><i
                                                    class="fa fa-cogs"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-warning btn-sm"><i
                                                    class="fa fa-question"></i></a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-history scrollable-container"
                                style=" position: relative; height: 400px;overflow-y: auto;">
                                <ul class="m-b-0" id="box-message">



                                </ul>
                            </div>
                            <div class="chat-message clearfix">
                                <div class="attachment-preview-container mb-2"></div>

                                <div class="input-group mb-0">
                                    {{-- <button id="scrollToBottom" class="btn btn-primary mt-2"><i
                                            class="bi bi-arrow-down"></i></button> --}}

                                    <div class="btn-group dropup ">
                                        <span class="btn " type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-paperclip text-black fw-3 fs-5"></i>
                                        </span>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-item"><span class="ms-3 "><label for="document"><i
                                                            class="bi bi-file-earmark"></i> Dokumen</label><input
                                                        type="file" name="document" accept=".pdf, .doc, .docx, .xlsx"
                                                        id="document" style="display: none"></span>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li class="dropdown-item"><span class="ms-3 "><label for="gambarin"><i
                                                            class="bi bi-file-earmark-image"></i> Gambar</label><input
                                                        type="file" name="gambar" id="gambarin"
                                                        accept=".jpg, .jpeg, .png, .PNG, .webp"
                                                        style="display: none"></span>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li class="dropdown-item"><span class="ms-3 "><label for="video"> <i
                                                            class="bi bi-play-circle"></i> Video</label><input
                                                        type="file" name="video" id="video" accept="video/*"
                                                        style="display: none"></span></li>
                                        </ul>
                                    </div>

                                    <input type="text" class="form-control" id="messageInput"
                                        placeholder="Enter text here...">
                                    <span class="input-group-text" id="sendMessage"><i class="fa fa-send"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="notif" class="toast-container position-fixed bottom-0 end-0 p-3">


        </div>
        <audio id="notificationSound" src="{{ asset('assets/notif/notif.mp3') }}" preload="auto"></audio>
    </section>
@section('script')
    <script>
        //     const toastTrigger = document.getElementById('liveToastBtn')
        // const toastLiveExample = document.getElementById('liveToast')

        // if (toastTrigger) {
        // const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        // toastTrigger.addEventListener('click', () => {
        // toastBootstrap.show()
        // })
        // }
    </script>

    <script>
        $('#document').on('change', function() {
            console.log('document')
            const files = $(this)[0].files
            $('.attachment-preview-container').empty(); // Clear previous previews
            $('#messageInput').attr('disabled', true)
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    const fileType = file.type;
                    let previewElement;
                    previewElement = `
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 5px;">
                            <span class="doc-icon"><i class="bi bi-file-earmark-text"></i></span> <button onclick="closePreview()" id="close-preview" style="border:none;background:none;" class=" float-end"><i class="bi bi-x"></i></button>
                            <p>${file.name}</p>
                        </div>`;

                    // Append the preview to the preview container
                    $('#gambarin').val(null);
                    $('#video').val(null);
                    $('.attachment-preview-container').append(previewElement);
                });
            }
        })
        $('#gambarin').on('change', function() {
            console.log('gambar')
            const files = $(this)[0].files
            $('.attachment-preview-container').empty(); // Clear previous previews
            $('#messageInput').attr('disabled', true)
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    const imgURL = URL.createObjectURL(file);

                    const fileType = file.type;
                    let previewElement;

                    previewElement = `
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 5px;">
                            <img src="${imgURL}" width="80px;" alt="Image Preview"> <button onclick="closePreview()" id="close-preview" style="border:none;background:none;" class=" float-end"><i class="bi bi-x"></i></button>
                            <p>${file.name}</p>
                        </div>`;

                    // Append the preview to the preview container
                    $('#document').val(null);
                    $('#video').val(null);
                    $('.attachment-preview-container').append(previewElement);
                });
            }
        })
        $('#video').on('change', function() {
            console.log('video')
            const files = $(this)[0].files
            $('.attachment-preview-container').empty(); // Clear previous previews
            $('#messageInput').attr('disabled', true)
            if (files.length > 0) {
                $.each(files, function(index, file) {
                    // const imgURL = URL.createObjectURL(file);

                    const fileType = file.type;
                    let previewElement;

                    previewElement = `
                        <div class="attachment-preview" style="border-radius:10px;  background-color: white;padding: 5px;">
                            <span class="doc-icon"><i class="bi bi-file-earmark-text"></i></span> <button onclick="closePreview()" id="close-preview" style="border:none;background:none;" class=" float-end"><i class="bi bi-x"></i></button>
                            <pr>${file.name}</p>
                        </div>`;

                    // Append the preview to the preview container
                    $('#document').val(null);
                    $('#gambarin').val(null);
                    $('.attachment-preview-container').append(previewElement);
                });
            }
        })

        function closePreview() {
            $('.attachment-preview-container').empty();
            $('#document').val(null);
            $('#gambarin').val(null);
            $('#video').val(null);
            $('#messageInput').removeAttr('disabled')
        };
    </script>
    <script>
        // const conversationId = document.getElementById('conversation-id').value;
        // var lastMessageTime = new Date();

        const cabangId = {{ auth()->user()->branch_code }};
        const inputConversationId = $('#currentConversationId').val();
        var baseUrl = window.location.origin;
        // const ws = new WebSocket(`ws://localhost:8080?wilayah_id=${wilayahId}`);
        let socket = null;
        // const baseWsUrl = 'ws://localhost:8080/chat';
        const baseWsUrl = 'ws://10.220.60.63:8090?type=admin&';

        if (Notification.permission !== 'granted') {
            Notification.requestPermission();
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var currentConversationId;
            // setInterval(function() {
            //             // Reload halaman setiap 2000 milidetik (2 detik)
            //             location.reload();
            //         }, 2000); // 2 detik
            loadConversations();

       
              $(document).on('click', '.list-message', function() {
                $('.list-message').removeClass('active')
                // $('.list-message a').css('color', '#000')
                let img = $(this).data('img');
                if (currentConversationId !== undefined) {
                    Echo.leave(`conversations.${currentConversationId}`);
                }
                // console.log(img)
                if (img) {
                    $('#img-customer').html(
                        `<img src="{{ asset('assets/img/customer/${img}') }}" alt="avatar">`)
                } else {
                    $('#img-customer').html(`<img src="{{ asset('assets/img/person.png') }}" alt="avatar">`)

                }
                currentConversationId = $(this).data('id');
                $('#currentConversationId').val(currentConversationId)
                $('#nama-title').text($(this).data('name'));
                $('#cabang-title').text($(this).data('cabang'));
                $(this).addClass('active')

                // console.log($(this, '.list-message a').text())
                loadMessages(currentConversationId);
                connectWebSocket(currentConversationId);

            });
            
            $('#messageInput').keyup(function (e) {
                  if (e.which == 13) {
                    const message = $('#messageInput').val();
                console.log(currentConversationId)
                if (message && currentConversationId) {
                    $.post('messages', {
                        conversation_id: currentConversationId,
                        message: message,
                        
                        created_date : now(),
                    }, function(data) {
                        console.log(data)

                        // $('#box-message').append(
                        //     `    <div class=" justify-content-end" id="penerima"    >

                        //                     <p class="small p-2  text-white mb-1 rounded-3  " style="background-color: #3498db;margin-left: 40px;">
                        //                         ${data.message} <span class="small ms-3 mb-3 rounded-3">
                        //                             ${waktu(data.created_date)} <i class="bi bi-eye"></i></span></p>

                        //                 </div> `
                        // )
                         $('#box-message').append(

                            ` <li class="clearfix">
                                <div class="message other-message float-end" > ${data.message} </div>
                                                            <div class="message-data text-end" style="margin-top:70px;">
                                                                <span class="message-data-time" > ${waktu(data.created_date)} <i class="bi bi-eye"></i></span>
                                                             
                                                            </div>
                                                        </li>`
                        )

                        $('#messageInput').val('');
                        loadMessages(currentConversationId)
                        
                    });
                }
                  }
                });

            $('#sendMessage').click(function() {
                const message = $('#messageInput').val();
                console.log(currentConversationId);
                console.log(now())
                const files = $('#document')[0].files
               const imageFiles = $('#gambarin')[0].files;
               const videoFiles = $('#video')[0].files;
console.log(files);
               
                if (message && currentConversationId) {
                    if(files[0]){
                        console.log('ada file')
                    }else {
                        console.log('belum ada file')
                    }
                    
                    $.post('messages', {
                        conversation_id: currentConversationId,
                        message: message,
                        created_date : now(),
                    }, function(data) {
                        console.log(data)

                        // $('#box-message').append(  `<div class="  mb-2 rounded-3 justify-content-end" id="penerima" style="padding:5px;background-color: #3498db;margin-left: 40px;">
                        //             <p class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300;"  >
                        //             ${data.message}</p> <span  style="font-size: 8pt; color :#d4d3d3;margin-top:-13px; margin-right: 15px;" class=" float-end ms-3 rounded-3 ">
                        //             ${waktu(data.created_date)}  <i class="bi bi-eye"></i></span></div> ` );
                       $('#box-message').append(

                             ` <li class="clearfix">
                                 <div class="message other-message float-end" > ${data.message} </div>
                                  <div class="message-data text-end" style="margin-top:70px;">
                                  <span class="message-data-time" > ${waktu(data.created_date)} <i class="bi bi-eye"></i></span>
                                    </div>
                               </li>`);

                        $('#messageInput').val('');
                        loadMessages(currentConversationId)
                        
                    });
                } else if(imageFiles[0] && imageFiles[0].type.startsWith('image/') && currentConversationId){
                    uploadFile(imageFiles[0], 'IMAGE', currentConversationId);
                } else if(files[0] && files[0].type === 'application/pdf' && currentConversationId){
                    uploadFile(files[0], 'FILE', currentConversationId);
                }else if (videoFiles.length > 0 && videoFiles[0].type.startsWith('video/') && currentConversationId) {
                    console.log('Video file detected');
                    uploadFile(videoFiles[0], 'VIDEO', currentConversationId);
                }
                
                // else if(files.type.startsWith('image/') && currentConversationId){
                //     console.log('gambar')
                //      var fileSize = files[0].size / 1024 / 1024; // Ukuran file dalam MB

                //         if (fileSize > 10) { // Batas ukuran 10 MB
                //             alert('Ukuran file tidak boleh lebih dari 10 MB');
                //             return false; // Hentikan proses pengiriman
                //         }
                //  var formData = new FormData();
                // formData.append('file', $('#gambarin')[0].files[0]);
                // formData.append('created_date', now())
                // formData.append('type','IMAGE')
                // formData.append('conversation_id', currentConversationId)
             
                //       console.log(formData.conversation_id);
                  
               
                //     $.ajax({
                //         url: "messages",
                //         type: "POST",
                //         // conversation_id: currentConversationId,
                //         data: formData,
                //         // created_date : now(),
                //         // enctype: 'multipart/form-data',
                //         contentType: false, // Use false to prevent jQuery from overriding the Content-Type header
                //         processData: false, // Use false to prevent jQuery from trying to process the data
                //         success: function(data) {
                //           console.log(data)

                //         $('#box-message').append(  `<div class="  mb-2 rounded-3 justify-content-end" id="penerima" style="padding:5px;background-color: #3498db;margin-left: 40px;">
                //                     <p class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300;"  >
                //                     ${data.message}</p> <span  style="font-size: 8pt; color :#d4d3d3;margin-top:-13px; margin-right: 15px;" class=" float-end ms-3 rounded-3 ">
                //                     ${waktu(data.created_date)}  <i class="bi bi-eye"></i></span></div> ` );
                      

                //         $('#messageInput').removeAttr('disabled')
                //         $('#messageInput').val('');
                //           $('.attachment-preview-container').empty(); // Clear previous previews
                //         loadMessages(currentConversationId)
                //         },
                //         error: function(response) {
                //             alert('File upload failed!');
                //             console.log(response);
                //         }
                //     });     
                // }else if(files[0].type == 'application/pdf'  && currentConversationId){
                //     console.log('dokument')
                //      var fileSize = files[0].size / 1024 / 1024; // Ukuran file dalam MB

                //     if (fileSize > 10) { // Batas ukuran 10 MB
                //         alert('Ukuran file tidak boleh lebih dari 10 MB');
                //         return false; // Hentikan proses pengiriman
                //     }
                //  var formData = new FormData();
                // formData.append('file', $('#document')[0].files[0]);
                // formData.append('created_date', now())
                // formData.append('type', 'FILE')
                // formData.append('conversation_id', currentConversationId)
             
                //       console.log(formData.conversation_id);
                  
               
                //     $.ajax({
                //         url: "messages",
                //         type: "POST",
                //         // conversation_id: currentConversationId,
                //         data: formData,
                //         // created_date : now(),
                //         // enctype: 'multipart/form-data',
                //         contentType: false, // Use false to prevent jQuery from overriding the Content-Type header
                //         processData: false, // Use false to prevent jQuery from trying to process the data
                //         success: function(data) {
                //           console.log(data)

                //         $('#box-message').append(  `<div class="  mb-2 rounded-3 justify-content-end" id="penerima" style="padding:5px;background-color: #3498db;margin-left: 40px;">
                //                     <p class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300;"  >
                //                     ${data.message}</p> <span  style="font-size: 8pt; color :#d4d3d3;margin-top:-13px; margin-right: 15px;" class=" float-end ms-3 rounded-3 ">
                //                     ${waktu(data.created_date)}  <i class="bi bi-eye"></i></span></div> ` );
                      

                //         $('#messageInput').removeAttr('disabled')
                //         $('#messageInput').val('');
                //           $('.attachment-preview-container').empty(); // Clear previous previews
                //         loadMessages(currentConversationId)
                //         },
                //         error: function(response) {
                //             alert('File upload failed!');
                //             console.log(response);
                //         }
                //     });     
                // }
                
              
                // if(currentConversationId == null){

                // }


            });
            
        });

function uploadFile(file, type, currentConversationId) {
    var fileSize = file.size / 1024 / 1024; // Ukuran file dalam MB
    if (fileSize > 10) {
        alert('Ukuran file tidak boleh lebih dari 10 MB');
        return false; // Hentikan proses pengiriman
    }
    var formData = new FormData();
    formData.append('file', file);
    formData.append('created_date', now());
    formData.append('type', type);
    formData.append('conversation_id', currentConversationId);

    $.ajax({
        url: "messages",
        type: "POST",
        data: formData,
        contentType: false, // Use false to prevent jQuery from overriding the Content-Type header
        processData: false, // Use false to prevent jQuery from trying to process the data
        success: function(data) {
            // displayMessage(data);
            $('#messageInput').removeAttr('disabled');
            $('#messageInput').val('');
            $('.attachment-preview-container').empty(); // Clear previous previews
               $('#document').val(null);
              $('#gambarin').val(null);
               $('#video').val(null);
            loadMessages(currentConversationId);
        },
        error: function(response) {
            alert('File upload failed!');
            console.log(response);
        }
    }); 
}

        function tanggal(waktu) {

            const dateStr = '2024-07-30T10:00:21.000000Z';
            const date = waktu.split('T')[0]; // Mendapatkan bagian waktu, yaitu '10:00:21.000000'
            // const [hours, minutes] = timePart.split('-');
            return date
        }

        function Tanggal(tanggal) {

            // Memecah string menjadi tanggal dan waktu (opsional)
            var parts = tanggal.split('T');
            var datePart = parts[0];

            // Memecah bagian tanggal menjadi komponen-komponennya
            var dateComponents = datePart.split('-');
            var year = dateComponents[0];
            var month = dateComponents[1];
            var day = dateComponents[2];
            // Membentuk string tanggal dalam format yang diinginkan (tanggal-bulan-tahun)
            var formattedDate = day + '-' + month + '-' + year;
            return formattedDate;
        }

        function loadConversations() {
            $.get('conversations', function(data) {
                $('#conversationList').empty();
                // console.log(data + "sddsd")
                if (data.length == 0) {
                    // $('#generateChat').css('display', 'block')
                    $('#sendMessage').attr('disabled', '')
                    $('#alert').css('display', 'block')
                } else {
                    $('#sendMessage').removeAttr('disabled', '')
                    // $('#generateChat').css('display', 'none')
                }
                data.forEach(conversation => {
                    console.log(conversation)
                    if (conversation.customer.foto_customer) {
                        $('#conversationList').append(

                            `  <li class="clearfix list-message" data-name="${conversation.customer.nama_customer}" data-img="${conversation.customer.foto_customer}" data-id="${conversation.id}" data-cabang="${conversation.branch.nm_cabang}">                            
                            <img src="{{ asset('assets/img/customer/${conversation.customer.foto_customer}') }}" alt="avatar">
                                    <div class="about">
                                        <div class="name">${conversation.customer.nama_customer}</div>
                                        <div class="status"> <i class="fa fa-circle offline"></i> <span class="time-last"> ${waktu(conversation.latest_message.created_date)}</span></div>
                                    </div>
                                </li>`
                        );
                    } else {
                        $('#conversationList').append(

                            `  <li class="clearfix list-message" data-name="${conversation.customer.nama_customer}" data-img="${conversation.customer.foto_customer}" data-id="${conversation.id}" data-cabang="${conversation.branch.nm_cabang}">                            
                            <img src="{{ asset('assets/img/person.png') }}" alt="avatar">
                                    <div class="about">
                                        <div class="name">${conversation.customer.nama_customer}</div>
                                        <div class="status"> <i class="fa fa-circle offline"></i> ${waktu(conversation.latest_message.created_date)}</div>
                                    </div>
                                </li>`
                        );
                    }
                });
            });
        }


        function showDesktopNotification(message, from) {
            if (Notification.permission === 'granted') {
                const notification = new Notification(from, {
                    body: message,
                    icon: "{{ asset('assets/img/logo-jamkrindo-bg.png') }}" // You can add an icon here
                });

                notification.onclick = () => {
                    window.focus(); // Bring the chat window to the front
                    notification.close(); // Close the notification when clicked
                };
            } else {
                console.log('Notification permission is not granted.');
            }
        }


        function connectWebSocket(chatId) {
            return new Promise((resolve, reject) => {
                if (socket && socket.readyState === WebSocket.OPEN) {
                    console.log('WebSocket is already connected.');
                    resolve(chatId); // Resolve the promise if already connected
                    return;
                }

                const wsUrl =
                    `${baseWsUrl}id_cabang=${cabangId}&id_user={{ auth()->user()->kd_user }}&conversation_id=${chatId}`;
                console.log('Connecting to:', wsUrl);
                socket = new WebSocket(wsUrl);

                socket.onopen = function() {
                    console.log('WebSocket connection opened.');
                    resolve(chatId); // Resolve the promise when connection opens
                };

                socket.onmessage = function(event) {
                    const data = JSON.parse(event.data);
                    playNotificationSound()
                    var lastMessageTime = new Date().toISOString();

                    const inputConversationId = $('#currentConversationId').val();

                    // onMessageReceived();
                    console.log(data);
                    console.log(inputConversationId);

                    if (data.conversation_id == inputConversationId) {

                        $('#box-message').append(
                            ` <li class="clearfix">
                                <div class="message my-message">${data.message}</div>
                                <div class="message-data">
                                  <span class="message-data-time">${data.created_at}<i class="bi bi-eye"></i></span>
                                   </div>
                                   </li>`
                        );
                    }
                    // const notif = $('#toast');

                    const toast = $('#toast');
                    $('.name-from').text(data.send_id);
                    toast.addClass('show');
                    setTimeout(function() {
                        toast.removeClass('show');
                    }, 3000); // Toast will be visible for 3 seconds

                    // setTimeout(function() {
                    //     notif.fadeOut()
                    // }, 2000);

                    // $('#notif').append(` <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                //      <div class="toast-header">
                //      <strong class="me-auto"> ${data.send_id}</strong>
                //         <small class="text-body-secondary timeElapsed"  data-timestamp="${lastMessageTime}"><span class="time-elapsed"></span> </small>
                //          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                //         </div>
                //         <div class="toast-body">
                //              ${data.message}
                //                  </div>
                //           </div>`);
                    var chatContainer = $('#box-message');
                    chatContainer.scrollTop(chatContainer[0].scrollHeight);
                    showDesktopNotification(data.message, data.send_id);
                };

                socket.onclose = function() {
                    console.log('WebSocket connection closed.');
                };

                socket.onerror = function(error) {
                    console.error('WebSocket error:', error);
                    reject(error); // Reject the promise if there's an error
                };
            });

        }


        // function timeSinceLastMessage() {
        //     var now = new Date();
        //     var timeDifference = now - lastMessageTime;

        //     var seconds = Math.floor((timeDifference / 1000) % 60);
        //     var minutes = Math.floor((timeDifference / (1000 * 60)) % 60);
        //     var hours = Math.floor((timeDifference / (1000 * 60 * 60)) % 24);
        //     var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

        //     var timeString = '';

        //     if (days > 0) {
        //         timeString += days + ' hari ';
        //     }
        //     if (hours > 0 || days > 0) {
        //         timeString += hours + ' jam ';
        //     }
        //     if (minutes > 0 || hours > 0 || days > 0) {
        //         timeString += minutes + ' menit ';
        //     }
        //     timeString += seconds + ' detik yang lalu';

        //     return timeString;
        // }
        function updateElapsedTime() {
            $('.timeElapsed').each(function() {
                var messageElement = $(this);
                var messageTime = new Date(messageElement.attr('data-timestamp'));
                if (isNaN(messageTime)) {
                    console.error('Invalid timestamp:', messageElement.attr('data-timestamp'));
                    return;
                }

                var now = new Date();
                var timeDifference = now - messageTime;

                var seconds = Math.floor((timeDifference / 1000) % 60);
                var minutes = Math.floor((timeDifference / (1000 * 60)) % 60);
                var hours = Math.floor((timeDifference / (1000 * 60 * 60)) % 24);
                var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));

                var timeString = '';

                if (days > 0) {
                    timeString += days + ' hari ';
                }
                if (hours > 0 || days > 0) {
                    timeString += hours + ' jam ';
                }
                if (minutes > 0 || hours > 0 || days > 0) {
                    timeString += minutes + ' menit ';
                }
                timeString += seconds + ' detik yang lalu';
                console.log($(this).parent())
                messageElement.find('.time-elapsed').text(timeString);
            });

        }


        function waktu(waktu) {

            const dateStr = '2024-07-30T10:00:21.000000Z';
            const timePart = waktu.split('T')[1].split('Z')[
                0]; // Mendapatkan bagian waktu, yaitu '10:00:21.000000'
            const [hours, minutes] = timePart.split(':');
            return hours + ":" + minutes
        }

        function waktuAL(waktu) {


            var date = new Date(waktu);

            // Get hours and minutes
            var hours = date.getHours().toString().padStart(2, '0');
            var minutes = date.getMinutes().toString().padStart(2, '0');

            var time = hours + ':' + minutes;
            return time
        }

        function generateChat(cabang_id) {
            $.post('customer/conversations', {
                cabang_id: cabang_id,
                user_id: '{{ auth()->user()->kd_customer }}'
            }, function(data) {
                loadConversations()
            });
        }

        function loadMessages(conversationId) {
            let lastDate = "";
            $.get(`conversations/${conversationId}/messages`, function(data) {
                //$('#box-message').empty();
                $('#box-message').html(data);
                data.forEach(message => {
                    let dateNow = tanggal(message.created_date);
                    // console.log(tanggal(message.created_date))
                    if (dateNow !== lastDate) {
                        $('#box-message').append(

                            ` <p  class="text-center fw-bold"> ${lastDate}</p>
                            `
                        )

                        lastDate = dateNow;
                    }
                    // console.log(message)
                    if (message.status) {
                        //$('#box-message').append(`
                        //      <li class="clearfix">
                        //         <div class="message other-message float-end" > ${message.message} </div>
                        //            <div class="message-data text-end" style="padding-top:70px;">
                        //                 <span class="message-data-time" >${waktu(message.created_date)}  <i class="bi bi-eye"></i></span>
                        //                    </div>
                        //      </li> `);
                        if(message.type_message == "FILE"){
                            //       $('#box-message').append( `<div class="  mb-2 rounded-3 justify-content-end" id="penerima" style="padding:5px;background-color: #3498db;margin-left: 40px;">
                            //         <p class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300;"  >
                            //  <div class="text-white"> <i class="bi bi-file-earmark-text"></i> <span>Pdf</span></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></p> <span  style="font-size: 8pt; color :#d4d3d3;margin-top:-13px; margin-right: 15px;" class="float-end ms-3 rounded-3 ">
                            //         ${waktu(message.created_date)}  <i class="bi bi-eye"></i></span></div> ` );
                                     $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" >    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>Pdf</span></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></div>
                              <div class="message-data text-end" style="padding-top:90px;">
                                <span class="message-data-time" >${waktu(message.created_date)}  <i class="bi bi-eye"></i></span>
                            </div>
                          </li> `);
                        }else if(message.type_message == "IMAGE"){
                            //       $('#box-message').append( `<div class="  mb-2 rounded-3 justify-content-end" id="penerima" style="padding:5px;background-color: #3498db;margin-left: 40px;">
                            //         <p class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300;"  >
                            //  <div class="text-white"><img src="../../assets/files/${message.message}" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></p> <span  style="font-size: 8pt; color :#d4d3d3;margin-top:-13px; margin-right: 15px;" class="float-end ms-3 rounded-3 ">
                            //         ${waktu(message.created_date)}  <i class="bi bi-eye"></i></span></div> ` );
                            //                 $('#box-message').append(`
                            //  <li class="clearfix">
                            //      <div class="message other-message float-end" >   <div class=""><img src="../../assets/files/${message.message}" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></div>
                            //       <div class="message-data text-end" style="padding-top:90px;">
                            //         <span class="message-data-time" >${waktu(message.created_date)}  <i class="bi bi-eye"></i></span>
                            //     </div>
                            //   </li> `);
                                            $('#box-message').append(`
                            <li class="clearfix">
                            <div class="message other-message float-end">
                                <div class=""><img src="../../assets/files/${message.message}" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button>
                                <div class="message-data text-end">
                                    <span class="message-data-time">${nowTime()}<i class="bi bi-eye"></i></span>
                                </div>
                            </div>
                        </li>`);
                        } else if(message.type_message == "VIDEO"){
                            //       $('#box-message').append( `<div class="  mb-2 rounded-3 justify-content-end" id="penerima" style="padding:5px;background-color: #3498db;margin-left: 40px;">
                            //         <p class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300;"  >
                            //  <div class="text-white"><video style="max-width: 100%; height: auto;" controls ><source src="../../assets/files/${message.message}"  type="video/mp4"></video></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></p> <span  style="font-size: 8pt; color :#d4d3d3;margin-top:-13px; margin-right: 15px;" class="float-end ms-3 rounded-3 ">
                            //         ${waktu(message.created_date)}  <i class="bi bi-eye"></i></span></div> ` );
                        $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" >  <div class=""><video style="max-width: 100%; height: auto;" controls ><source src="../../assets/files/${message.message}"  type="video/mp4"></video></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></div>
                              <div class="message-data text-end" style="padding-top:90px;">
                                <span class="message-data-time" >${waktu(message.created_date)}  <i class="bi bi-eye"></i></span>
                            </div>
                          </li> `);
                        } else {
                        $('#box-message').append(`
                         <li class="clearfix">
                             <div class="message other-message float-end" > ${message.message} </div>
                              <div class="message-data text-end" style="padding-top:70px;">
                                <span class="message-data-time" >${waktu(message.created_date)}  <i class="bi bi-eye"></i></span>
                            </div>
                          </li> `);
                        }
                    } else {
                         if(message.type_message == "FILE"){
                             $('#box-message').append(`
                            <li class="clearfix">
                                <div class="message my-message">    <div class=""> <i class="bi bi-file-earmark-text"></i> <span>Pdf</span></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></div>
                                <div class="message-data">
                                    <span class="message-data-time">${waktu(message.created_date)} <i class="bi bi-eye"></i></span>
                                </div> </li>`);
                            //   $('#box-message').append(
                            // `<div class="  mb-2 rounded-3 justify-content-sta"rt" id="penerima" style="padding:5px;background-color: #457B9D;margin-right: 40px;margin-left: 10px;">
                            //         <p  class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300; "> 
                            //         <div class="text-white"> <i class="bi bi-file-earmark-text"></i> <span>Pdf</span></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></p> <span  style="font-size: 8pt; color:#d4d3d3; margin-top:-13px; margin-right: 15px;" class="float-end ms-3 rounded-3 ">
                            //         ${waktu(message.created_date)}  <i class="bi bi-eye"></i></span></div> `);
                         }else if(message.type_message == "IMAGE"){
                             $('#box-message').append(   ` <li class="clearfix">
                                <div class="message my-message">    <div class=""><img src="../../assets/files/${message.message}" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></div>
                                <div class="message-data">
                                    <span class="message-data-time">${waktu(message.created_date)}   <i class="bi bi-eye"></i></span>
                                </div> </li>`);
                            //       $('#box-message').append( `<div class="  mb-2 rounded-3 justify-content-end" id="penerima" style="padding:5px;background-color: #457B9D;margin-right: 40px;margin-left: 10px;">
                            //         <p class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300;"  >
                            //  <div class="text-white"><img src="../../assets/files/${message.message}" class="img-thumbnail" max-width="50px;"  ></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></p> <span  style="font-size: 8pt; color :#d4d3d3;margin-top:-13px; margin-right: 15px;" class="float-end ms-3 rounded-3 ">
                            //         ${waktu(message.created_date)}  <i class="bi bi-eye"></i></span></div> ` );
                        }else if(message.type_message == "VIDEO"){
                                  $('#box-message').append(   ` <li class="clearfix">
                                <div class="message my-message">     <div class=""><video style="max-width: 100%; height: auto;" controls ><source src="../../assets/files/${message.message}"  type="video/mp4"></video></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></div>
                                <div class="message-data">
                                    <span class="message-data-time">${waktu(message.created_date)}   <i class="bi bi-eye"></i></span>
                                </div> </li>`);
                            //       $('#box-message').append( `<div class="  mb-2 rounded-3 justify-content-end" id="penerima" style="padding:5px;background-color: #457B9D;margin-right: 40px;margin-left: 10px;">
                            //         <p class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300;"  >
                            //  <div class="text-white"><video style="max-width: 100%; height: auto;" controls ><source src="../../assets/files/${message.message}"  type="video/mp4"></video></div><button onclick="downloadBtn('${message.message}')"  style="border:none" id="downloadBtn" class="badge bg-secondary downloadBtn">Unduh File</button></p> <span  style="font-size: 8pt; color :#d4d3d3;margin-top:-13px; margin-right: 15px;" class="float-end ms-3 rounded-3 ">
                            //         ${waktu(message.created_date)}  <i class="bi bi-eye"></i></span></div> ` );
                        } else{
                         
                    $('#box-message').append(
                            ` <li class="clearfix">
                                <div class="message my-message">${message.message}</div>
                                <div class="message-data">
                                    <span class="message-data-time">${waktu(message.created_date)} <i class="bi bi-eye"></i></span>
                                </div> </li>`);
                        // $('#box-message').append(
                        //     `<div class="  mb-2 rounded-3 justify-content-sta"rt" id="penerima" style="padding:5px;background-color: #457B9D;margin-right: 40px;margin-left: 10px;">
                        //             <p  class=" text-white" style="margin-bottom:12px; margin-left:4px;font-weight:300; "> 
                        //             ${message.message}</p> <span  style="font-size: 8pt; color:#d4d3d3; margin-top:-13px; margin-right: 15px;" class="float-end ms-3 rounded-3 ">
                        //             ${waktu(message.created_date)}  <i class="bi bi-eye"></i></span></div> `);
                    }
                        //$('#box-message').append(
                        //    ` <li class="clearfix">
                        //        <div class="message my-message">${message.message}</div>
                        //        <div class="message-data">
                        //            <span class="message-data-time">${waktu(message.created_date)}  <i class="bi bi-eye"></i></span>
                        //        </div> </li>`);
                    }
                    //var chatContainer = $('#box-message');
                    //chatContainer.scrollTop(chatContainer[0].scrollHeight);
                });
                setTimeout(function () {
                    $('.chat-history').scrollTop($('#box-message').height());
                }, 100);
            });
        }

        function updateConversationId(newId) {
            currentConversationId = newId;
            console.log('Conversation ID updated:', currentConversationId);
            connectWebSocket(currentConversationId); // Reconnect dengan ID baru
        }

        // Update currentConversationId saat pengguna memilih percakapan baru
        function nowTime() {
            var now = new Date();

            // Mendapatkan bagian-bagian dari tanggal dan waktu
            var year = now.getFullYear(); // Mendapatkan tahun (2024)
            var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Mendapatkan bulan (08)
            var day = now.getDate().toString().padStart(2, '0'); // Mendapatkan hari (16)

            var hours = now.getHours().toString().padStart(2, '0'); // Mendapatkan jam (04)
            var minutes = now.getMinutes().toString().padStart(2, '0'); // Mendapatkan menit (04)
            var seconds = now.getSeconds().toString().padStart(2, '0'); // Mendapatkan detik (22)

            // Membuat format "YYYY-MM-DD HH:MM:SS"
            var formattedTime = hours + ':' + minutes;
            return formattedTime;
        }

        function now() {
            var now = new Date();

            // Mendapatkan bagian-bagian dari tanggal dan waktu
            var year = now.getFullYear(); // Mendapatkan tahun (2024)
            var month = (now.getMonth() + 1).toString().padStart(2, '0'); // Mendapatkan bulan (08)
            var day = now.getDate().toString().padStart(2, '0'); // Mendapatkan hari (16)

            var hours = now.getHours().toString().padStart(2, '0'); // Mendapatkan jam (04)
            var minutes = now.getMinutes().toString().padStart(2, '0'); // Mendapatkan menit (04)
            var seconds = now.getSeconds().toString().padStart(2, '0'); // Mendapatkan detik (22)

            // Membuat format "YYYY-MM-DD HH:MM:SS"
            var formattedTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
            return formattedTime;
        }

        function playNotificationSound() {
            var audio = $('#notificationSound')[0]; // Mengakses elemen audio
            audio.play(); // Memutar suara
        }

        // $('#closeChat').on('click', function() {
        //     if ($(this).data('convesation') == null) {
        //         return false;
        //     }
        //     $.ajax({
        //         url: "",
        //         type: "POST",
        //         data: ,
        //         beforeSend: function() {
        //             $('.btn-save').html("Loading...");
        //             $('.btn-save').attr("disabled", "");
        //         },
        //         error: function(res) {
        //             $('#branchModal').modal('hide');

        //             $('.pesan').text(res.status);
        //             $('#alert').addClass('show').fadeIn();
        //             setTimeout(
        //                 function() {
        //                     $('#alert').removeClass('show').fadeOut()
        //                 }, 3000);
        //             alert("Error");
        //         },
        //         success: function(res) {
        //             $('#branchModal').modal('hide');
        //             $('.pesan').text("Simpan " + res.status);
        //             $('#alert').addClass('show').fadeIn();
        //             setTimeout(
        //                 function() {
        //                     $('#alert').removeClass('show').fadeOut()x
        //                 }, 3000);
        //             // alert(res.status);
        //             reloadData();
        //         },
        //         complete: function() {
        //             $('.btn-save').html("Save");
        //             $('.btn-save').removeAttr("disabled");
        //             initialForm();
        //         }
        //     });
        // })
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // let websocket = connectWebSocket();
            loadConversations();
            // setInterval(function() {
            //     var elapsedTime = timeSinceLastMessage();
            //     $('#timeElapsed').text(elapsedTime);
            // }, 5000);
            // Perbarui waktu secara berkala
            setInterval(updateElapsedTime, 5000);

            function scrollToBottom() {
                var chatContainer = $('#box-message');
                chatContainer.scrollTop(chatContainer[0].scrollHeight);
            }

            // Ketika tombol "Ke Pesan Terakhir" diklik
            $('#scrollToBottom').click(function() {
                scrollToBottom();
                console.log('srol');
            });
            $(document).on('click', '.list-message', function() {
                $('.list-message').removeClass('active')
                // $('.list-message a').css('color', '#000')
                let img = $(this).data('img');
                console.log(img)
                if (img) {
                    $('#img-customer').html(
                        `<img src="{{ asset('assets/img/customer/${img}') }}" alt="avatar">`)
                } else {
                    $('#img-customer').html(`<img src="{{ asset('assets/img/person.png') }}" alt="avatar">`)

                }
                currentConversationId = $(this).data('id');
                $('#currentConversationId').val(currentConversationId)
                $('#nama-title').text($(this).data('name'));
                $('#cabang-title').text($(this).data('cabang'));
                $(this).addClass('active');
                $('#closeChat').data("conversation", currentConversationId);

                // console.log($(this, '.list-message a').text())
                loadMessages(currentConversationId);
                connectWebSocket(currentConversationId);

            });

            $('#messageInput').keyup(function(e) {
                if (e.which == 13) {

                    const message = $('#messageInput').val();
                    if (!message) return; // Jangan kirim jika tidak ada pesan

                    // Pastikan currentConversationId sudah terupdate dengan benar
                    if (!currentConversationId) {
                        console.error('No conversation ID set');
                        return;
                    }
                    console.log(" id " + currentConversationId)
                    connectWebSocket(currentConversationId).then(() => {
                        if (message && currentConversationId) {
                            socket.send(JSON.stringify({
                                conversation_id: currentConversationId,
                                message: message,
                                sender_id: '{{ auth()->user()->kd_user }}',
                                admin: true,
                                created_date: now(),
                                status: true
                            }));
                            console.log('Message sent to server');

                            $('#box-message').append(
                                ` <li class="clearfix">
                                                            <div class="message other-message float-end" > ${message} </div>
                                                            <div class="message-data text-end" style="padding-top:70px;">
                                                                <span class="message-data-time" >${nowTime()} <i class="bi bi-eye"></i></span>
                                                             
                                                            </div>
                                                        </li>`
                            )
                            $('#messageInput').val('');
                            var chatContainer = $('#box-message');
                            chatContainer.scrollTop(chatContainer[0].scrollHeight);
                        }
                    }).catch((error) => {
                        console.log('Failed to connect WebSocket: ' + error);
                    });
                }
            });


            $('#sendMessage').click(function() {
                const message = $('#messageInput').val();
                if (!message) return; // Jangan kirim jika tidak ada pesan

                // Pastikan currentConversationId sudah terupdate dengan benar
                if (!currentConversationId) {
                    console.error('No conversation ID set');
                    return;
                }
                console.log(" id " + currentConversationId)
                connectWebSocket(currentConversationId).then(() => {
                    if (message && currentConversationId) {
                        socket.send(JSON.stringify({
                            conversation_id: currentConversationId,
                            message: message,
                            sender_id: '{{ auth()->user()->kd_user }}',
                            admin: true,
                            created_date: now(),
                            status: true
                        }));
                        console.log('Message sent to server');

                        $('#box-message').append(

                            ` <li class="clearfix">
                                                            <div class="message other-message float-end" > ${message} </div>
                                                            <div class="message-data text-end" style="padding-top:70px;">
                                                                <span class="message-data-time" >${nowTime()}  <i class="bi bi-eye"></i></span>
                                                             
                                                            </div>
                                                        </li>`
                        )
                        $('#messageInput').val('');
                        var chatContainer = $('#box-message');
                        chatContainer.scrollTop(chatContainer[0].scrollHeight);
                    }
                }).catch((error) => {
                    console.log('Failed to connect WebSocket: ' + error);
                });
            });
        });
    </script>
@stop
@endsection
