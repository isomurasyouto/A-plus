@extends('full')

@section('title')
マイページ | A+plus
@stop

@section('css')

@stop

@section('meta')
<meta name="robots" content="noindex,nofollow">
@endsection

@section('main_content')
	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<p>
			入力の一部に誤りがあります。</p><br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="panel panel-success">
		<div class="panel-title">マイページ</div>
		<div class="panel-body">プロフィールを変更するには「編集」ボタンをクリックしてください。
			<div class="section-margin row-fluid">
				<div class="col3">
					<div class="panel panel-info">
						<div class="panel-title">プロフィール画像</div>
						<div class="panel-body">
							<img class="profile-value" width="100" height="100" src="{{ $user->avatar? $user->avatar:asset('image/dummy.png') }}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<a class="btn btn-sm btn-success btn-xs right-float" href="/mypage/avatar">編集</a>
						</div>
					</div>
				</div>
				<div class="col9">
					<div class="panel panel-info">
						<div class="panel-title">ユーザー名</div>
						<div class="panel-body">
							<form class="name" action='#' method='POST'>
								<span class="profile-value">{{ $user->name }}</span>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button class="btn btn-sm btn-success btn-xs edit-button right-float">編集</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row-fluid section-margin">
				<div class="col7">
					<div class="panel panel-warning">
						<div class="panel-title">登録メールアドレス</div>
						<div class="panel-body">
							<form class="email" action='#' method='POST'>
							<span class="profile-value">{{ $user->email }}</span>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button class="btn btn-sm btn-success btn-xs edit-button right-float">編集</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col5">
					<div class="panel panel-warning">
						<div class="panel-title">パスワード</div>
						<div class="panel-body">
							<span class="profile-value">**********</span>
						</div>
					</div>
				</div>
			</div>
			<div class="section-margin row-fluid">
				<div class="col4">
					<div class="panel panel-default">
						<div class="panel-title">性別</div>
						<div class="panel-body">
							<form class="sex" action='#' method='POST'>
							<span class="profile-value">{{ $user->sex }}</span>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button class="btn btn-sm btn-success btn-xs edit-button right-float">編集</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col4">
					<div class="panel panel-default">
						<div class="panel-title">入学年度</div>
						<div class="panel-body">
							<form class="entrance_year" action='#' method='POST'>
							<span class="profile-value">{{ $user->entrance_year }}{{ $user->entrance_year == "その他"? "":"年度"  }}</span>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button class="btn btn-sm btn-success btn-xs edit-button right-float">編集</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col4">
					<div class="panel panel-default">
						<div class="panel-title">学部</div>
						<div class="panel-body">
							<form class="faculty" action='#' method='POST'>
							<span class="profile-value">{{ $user->faculty }}</span>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<button class="btn btn-sm btn-success btn-xs edit-button right-float">編集</button>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div id="password-notice" class="panel-body">
					パスワードの変更は、お手数ですが一度パスワードをリセットしてから再設定となります。<br />
					<a href="/password/email">こちらから登録されているアドレスにメールを送信して再設定してください。</a>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-warning section-margin">
		<div class="panel-title">
			<div class="row-fluid">
				<div class="col1">
					My時間割
				</div>
				<!-- <div class="col1">
					<select id="year" name="year">
						<option value="2015">2015年度</option>
						<option value="2014">2014年度</option>
						<option value="2013">2013年度</option>
						<option value="2012">2012年度</option>
						<option value="2011">2011年度</option>
						<option value="2010">2010年度</option>
						<option value="2009">2009年度</option>
						<option value="2008">2008年度</option>
						<option value="2007">2007年度</option>
					</select>
				</div>
				<div class="col10">
					<select id="term" name="term">
						<option value="0">春学期・夏期集中</option>
						<option value="1">秋学期・冬期集中</option>
					</select>
				</div> -->
			</div>
		</div>
		<div class="panel-body">
			<table class="table table-bordered">
				<thead>
					<th></th>
					<th>月</th>
					<th>火</th>
					<th>水</th>
					<th>木</th>
					<th>金</th>
					<th>土</th> <!-- 土はあるかないかで表示非表示 -->
				</thead>
				<tr>
					<td>1</td>
					<td>{{ $time_table["月"]["１"]['class_registered']->class_name or "" }}<br>{{ $time_table["月"]["１"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["火"]["１"]['class_registered']->class_name or "" }}<br>{{ $time_table["火"]["１"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["水"]["１"]['class_registered']->class_name or "" }}<br>{{ $time_table["水"]["１"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["木"]["１"]['class_registered']->class_name or "" }}<br>{{ $time_table["木"]["１"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["金"]["１"]['class_registered']->class_name or "" }}<br>{{ $time_table["金"]["１"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["土"]["１"]['class_registered']->class_name or "" }}<br>{{ $time_table["土"]["１"]['class_registered_detail']->room_name or "" }}</td>
				</tr>
				<tr>
					<td>2</td>
					<td>{{ $time_table["月"]["２"]['class_registered']->class_name or "" }}<br>{{ $time_table["月"]["２"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["火"]["２"]['class_registered']->class_name or "" }}<br>{{ $time_table["火"]["２"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["水"]["２"]['class_registered']->class_name or "" }}<br>{{ $time_table["水"]["２"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["木"]["２"]['class_registered']->class_name or "" }}<br>{{ $time_table["木"]["２"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["金"]["２"]['class_registered']->class_name or "" }}<br>{{ $time_table["金"]["２"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["土"]["２"]['class_registered']->class_name or "" }}<br>{{ $time_table["土"]["２"]['class_registered_detail']->room_name or "" }}</td>
				</tr>
				<tr>
					<td>3</td>
					<td>{{ $time_table["月"]["３"]['class_registered']->class_name or "" }}<br>{{ $time_table["月"]["３"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["火"]["３"]['class_registered']->class_name or "" }}<br>{{ $time_table["火"]["３"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["水"]["３"]['class_registered']->class_name or "" }}<br>{{ $time_table["水"]["３"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["木"]["３"]['class_registered']->class_name or "" }}<br>{{ $time_table["木"]["３"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["金"]["３"]['class_registered']->class_name or "" }}<br>{{ $time_table["金"]["３"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["土"]["３"]['class_registered']->class_name or "" }}<br>{{ $time_table["土"]["３"]['class_registered_detail']->room_name or "" }}</td>
				</tr>
				<tr>
					<td>4</td>
					<td>{{ $time_table["月"]["４"]['class_registered']->class_name or "" }}<br>{{ $time_table["月"]["４"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["火"]["４"]['class_registered']->class_name or "" }}<br>{{ $time_table["火"]["４"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["水"]["４"]['class_registered']->class_name or "" }}<br>{{ $time_table["水"]["４"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["木"]["４"]['class_registered']->class_name or "" }}<br>{{ $time_table["木"]["４"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["金"]["４"]['class_registered']->class_name or "" }}<br>{{ $time_table["金"]["４"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["土"]["４"]['class_registered']->class_name or "" }}<br>{{ $time_table["土"]["４"]['class_registered_detail']->room_name or "" }}</td>
				</tr>
				<tr>
					<td>5</td>
					<td>{{ $time_table["月"]["５"]['class_registered']->class_name or "" }}<br>{{ $time_table["月"]["５"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["火"]["５"]['class_registered']->class_name or "" }}<br>{{ $time_table["火"]["５"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["水"]["５"]['class_registered']->class_name or "" }}<br>{{ $time_table["水"]["５"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["木"]["５"]['class_registered']->class_name or "" }}<br>{{ $time_table["木"]["５"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["金"]["５"]['class_registered']->class_name or "" }}<br>{{ $time_table["金"]["５"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["土"]["５"]['class_registered']->class_name or "" }}<br>{{ $time_table["土"]["５"]['class_registered_detail']->room_name or "" }}</td>
				</tr>
				<tr>
					<td>6</td>
					<td>{{ $time_table["月"]["６"]['class_registered']->class_name or "" }}<br>{{ $time_table["月"]["６"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["火"]["６"]['class_registered']->class_name or "" }}<br>{{ $time_table["火"]["６"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["水"]["６"]['class_registered']->class_name or "" }}<br>{{ $time_table["水"]["６"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["木"]["６"]['class_registered']->class_name or "" }}<br>{{ $time_table["木"]["６"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["金"]["６"]['class_registered']->class_name or "" }}<br>{{ $time_table["金"]["６"]['class_registered_detail']->room_name or "" }}</td>
					<td>{{ $time_table["土"]["６"]['class_registered']->class_name or "" }}<br>{{ $time_table["土"]["６"]['class_registered_detail']->room_name or "" }}</td>
				</tr>
				<!-- <tr>
					<td>7</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr> -->
				
			</table>
		</div>
	</div>
	<div class="panel panel-primary section-margin">
		<div class="panel-title">
			<div class="row-fluid">
				<div class="col4">レビュー履歴</div>
				<div class="col8">合計レビュー件数: <span style="color:#F35D5D;">{{ $reviews->count() }}件</span></div>
			</div>
		</div>
		<div class="panel-body">
			@if(!$reviews->count())
				<p style='color:#FF0000;'>まだレビューされていません。</p>
			@else
			@foreach($reviews as $review)
			<div class="panel panel-default">
				<div class="panel-title">
					<div class="row-fluid">
						<div class="col9" style='font-size:1.3em'>
							<a href="/classes/index/{{ $review->classes()->first()->class_id }}">{{ $review->classes()->first()->class_name }}</a>
							<form action="/mypage/edit" method="get" class="review-edit-delete">
									<input type="hidden" value="{{{ $review->review_id }}}" name="review_id">
									<input type="hidden" name="_token" value="{{csrf_token()}}" />
									<button type="submit" class="btn btn-success btn-sm" >編集</button>
						        </form>
						        <form action="/mypage/delete-confirm" method="POST" class="review-edit-delete">
						          	<input type="hidden" value="{{{ $review->review_id }}}" name="review_id">
						          	<input type="hidden" name="_token" value="{{csrf_token()}}" />
						          	<button type="submit" class="btn btn-danger btn-sm">削除</button>
						         </form>
						</div>
						<div class="col3">
							更新日時:{{ $review->updated_at }}

						</div>
					</div>
				</div>
				<div class="panel-title">
					<div class="row-fluid">
						<div class="col3">
						総合<span class="raty_stars" data-star="{{ $review->stars }}"></span>
						</div>
						<div class="col3">
						単位の取りやすさ<span class="raty_stars" data-star="{{ $review->unit_stars }}"></span>
						</div>
						<div class="col3">
						GP(成績)の取りやすさ<span class="raty_stars" data-star="{{ $review->grade_stars }}"></span>
						</div>
						<div class="col3">
						内容の充実度<span class="raty_stars" data-star="{{ $review->fulfill_stars }}"></span>
						</div>
					</div>
				</div>
				<div class="panel-body">
					{{ mb_strimwidth($review->review_comment,0,100,"...") }}
				</div>
			</div>
			@endforeach
			@endif
		</div>
	</div>
@stop

@section('js')
	<script type="text/javascript" >
		var message;
		<?php if(old("message")){ ?>
			message = <?php echo '"'.old("message").'"'; ?>;
		<?php } ?>

	</script>
	<script type="text/javascript" src="{{ asset('/js/mypage.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/raty_lib/jquery.raty.js') }}"></script>
@stop
