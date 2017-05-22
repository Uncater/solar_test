<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #f0f2fa;
                font-family: "PT Sans", "Helvetica Neue", "Helvetica", "Roboto", "Arial", sans-serif;
                /*font-size: 20px;*/
                color: #555f77;
                -webkit-font-smoothing: antialiased;
            }

            input, textarea {
                outline: none;
                border: none;
                display: block;
                margin: 0;
                padding: 0;
                -webkit-font-smoothing: antialiased;
                font-family: "PT Sans", "Helvetica Neue", "Helvetica", "Roboto", "Arial", sans-serif;
                font-size: 1rem;
                color: #555f77;
            }
            input::-webkit-input-placeholder, textarea::-webkit-input-placeholder {
                color: #ced2db;
            }
            input::-moz-placeholder, textarea::-moz-placeholder {
                color: #ced2db;
            }
            input:-moz-placeholder, textarea:-moz-placeholder {
                color: #ced2db;
            }
            input:-ms-input-placeholder, textarea:-ms-input-placeholder {
                color: #ced2db;
            }

            p {
                line-height: 1.3125rem;
            }

            .comments {
                margin: 2.5rem auto 0;
                max-width: 60.75rem;
                padding: 0 1.25rem;
            }

            .comment-wrap {
                margin-bottom: 1.25rem;
                display: table;
                width: 100%;
                min-height: 5.3125rem;
            }

            .comment-block {
                padding: 1rem;
                background-color: #fff;
                display: table-cell;
                vertical-align: top;
                border-radius: 0.1875rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.08);
            }
            .comment-block textarea {
                width: 100%;
                resize: none;
            }

            .comment-text {
                margin-bottom: 1.25rem;
            }

            .bottom-comment {
                color: #acb4c2;
                font-size: 0.875rem;
            }

            .comment-date {
                float: left;
            }

            .comment-actions {
                float: right;
            }
            .comment-actions li {
                display: inline;
                margin: -2px;
                cursor: pointer;
            }
            .comment-actions li.reply {
                padding-right: 0.75rem;
                border-right: 1px solid #e1e5eb;
            }
            .comment-actions li.edit {
                padding-right: 0.75rem;
                padding-left: 0.75rem;
                border-right: 1px solid #e1e5eb;
            }
            .comment-actions li.delete {
                padding-left: 0.75rem;
                padding-right: 0.125rem;
            }
            .comment-actions li:hover {
                color: #0095ff;
            }

            .btn {
                color: #fff;
                padding: 6px 12px;
                display: inline-block;
                font-size: 14px;
                font-weight: 400;
                text-align: center;
                border: 1px solid transparent;
                border-radius: 4px;
                margin-top: 1em;
            }
            .btn-primary {
                background-color: #0275d8;
                border-color: #0275d8;
            }
            .btn-danger {
                background-color: #d9534f;
                border-color: #d9534f;
            }

        </style>
        <script
                src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
                crossorigin="anonymous"></script>
    </head>
    <body>
    <div id="base-section" style="display: none;">
        <div class="comment-content">
            <div class="comment-wrap">
                <div class="comment-block">
                    <p class="comment-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto temporibus iste nostrum dolorem natus recusandae incidunt voluptatum. Eligendi voluptatum ducimus architecto tempore, quaerat explicabo veniam fuga corporis totam reprehenderit quasi
                        sapiente modi tempora at perspiciatis mollitia, dolores voluptate. Cumque, corrupti?</p>
                    <div class="bottom-comment">
                        <div class="comment-date">Aug 24, 2014 @ 2:35 PM</div>
                        <ul class="comment-actions">
                            <li class="reply">Reply</li>
                            <li class="edit">Edit</li>
                            <li class="delete">Delete</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="edit-section">
            <div class="comment-block">
                <textarea cols="30" rows="3" placeholder="Add comment..."></textarea>
                <button class="btn btn-md btn-primary edit-btn">Edit</button>
                <button class="btn btn-md btn-danger cancel-btn">Cancel</button>
            </div>
        </div>
    </div>
    <div class="comments">

        <div class="comment-wrap text-section">
            <div class="comment-block">
                <textarea cols="30" rows="3" placeholder="Add comment..."></textarea>
                <button class="btn btn-md btn-primary add-btn">Add</button>
            </div>
        </div>

        <div class="comment-section">
            @inject('comments', 'App\Services\CommentService')
            {!!  $comments->commentsToHTML() !!}
        </div>
    </div>

    </body>

    <script>
        jQuery.fn.extend({
            hasChildComment: function (id) {
                var hasChild = false;
                $('.comment-content').each(function() {
                    if ($(this).attr('data-parent-id') == id) {
                        hasChild = true;
                        return false;
                    }
                });
                return hasChild;
            },
            removeCommentWithParent: function () {
                if ($(this).attr('data-parent-id')) {
                    parentId = $(this).attr('data-parent-id');
                    do {
                        var parent = $('[data-id="' + parentId + '"]');
                        parentId = null;
                        if (parent.find('.comment-text').text() == 'This comment is deleted') {
                            if (parent.attr('data-parent-id')) {
                                parentId = parent.attr('data-parent-id');
                            }
                            parent.remove();
                        }
                    } while (parentId);
                }
                $(this).remove();
            },
        });
        function createComment(data) {
            var comment = $('#base-section .comment-content').clone();
            comment.attr('data-id', data.id);
            if ('parentId' in data) {
                comment.attr('data-parent-id', data.parentId);
            }
            comment.find('.comment-text').text(data.comment);
            comment.find('.comment-date').text(data.createdAt);
            return comment;
        }
        function createTextSection() {
            var textSection = $('.text-section').clone();
            textSection.find('textarea').val('');
            return textSection;
        }
        function addComment(data) {
            var comment = createComment(data);
            $('.comment-section').append(comment);
        }
        function addChildComment(data) {
            var parent = $('[data-id="' + data.parentId + '"]');
            parent.find('.text-section').remove();
            var comment = createComment(data);
            var newMargin = (parseInt(parent.css('margin-left')) + 20) + 'px';
            comment.css('margin-left', newMargin);
            comment.insertAfter(parent);
        }
        $(document).on('click', '.edit-btn', function () {
            var wrap = $(this).closest('.comment-wrap');
            var id = $(this).data('id');
            var route = "{{ route('comments.update', ":id") }}";
            route = route.replace(':id', id);
            var text = wrap.find('textarea').val();
            var data = {comment: text};
            $.ajax({
                type: "PATCH",
                url: route,
                data: data,
                context: $(this)
            })
            .done(function(response) {
                if(response.updated) {
                    $(this).parent().remove();
                    Object.assign(data, response);
                    wrap.find('.comment-block').show();
                    wrap.find('.comment-text').text(data.comment);
                    wrap.find('.comment-date').text(data.updatedAt).prepend('<i class="fa fa-edit"></i> ');
                }
            })
            .fail(function() {
                alert( "Error editing comment" );
            });
        });
        $(document).on('click', '.cancel-btn', function() {
            var wrap = $(this).closest('.comment-wrap');
            $(this).parent().remove();
            wrap.find('.comment-block').show();
        });
        $(document).on('click', '.reply', function() {
            var content = $(this).closest('.comment-content');
            var textSection = createTextSection();
            textSection.appendTo(content);
            var btn = content.find('.btn');
            var parentId = content.attr('data-id');
            btn.attr('data-parent-id', parentId);
        });
        $(document).on('click', '.edit', function() {
            var content = $(this).closest('.comment-content');
            var id = content.data('id');
            var editSection = $('#base-section .edit-section .comment-block').clone();
            var text = content.find('.comment-text').text();
            editSection.find('textarea').val(text);
            editSection.find('.edit-btn').attr('data-id', id);
            content.find('.comment-block').hide().after(editSection);
        });
        $(document).on('click', '.add-btn', function() {
            var btn = $(this);
            btn.prop('disabled', true);
            var textarea = $(this).parent().find('textarea');
            var text = textarea.val();
            if (text) {
                var data = {comment: text};
                childComment = false;
                if ($(this).attr('data-parent-id')) {
                    var childComment = true;
                    data.parentId = $(this).attr('data-parent-id');
                }
                $.post("{{ route('comments.store') }}", data, function(response) {
                    if(response.created) {
                        Object.assign(data, response);
                        if (childComment) {
                            addChildComment(data);
                        } else {
                            addComment(data);
                        }
                        textarea.val('');
                    }
                })
                .fail(function() {
                    alert( "Error leaving comment" );
                })
                .always(function() {
                    btn.prop('disabled', false);
                });
            }
        });
        $(document).on('click', '.delete', function() {
            var content = $(this).closest('.comment-content');
            var id = content.data('id');
            var route = "{{ route('comments.destroy', ":id") }}";
            route = route.replace(':id', id);
            $.ajax({
                type: "DELETE",
                url: route,
                context: $(this)
            })
            .done(function(response) {
                if(response.deleted) {
                    if ($(this).hasChildComment(id)) {
                        content.find('.comment-text').text('This comment is deleted');
                        content.find('.bottom-comment').remove();
                    } else {
                        content.removeCommentWithParent();
                    }
                }
            })
            .fail(function() {
                alert( "Error editing comment" );
            });
        });
    </script>
</html>
