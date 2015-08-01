@extends('master')

@section('sidebar')
@include('common.sidebar')
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/alertify.core.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/alertify.default.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/aplus_style.css') }}">
@stop

@section('title')
{{ $data['detail']['class_name'] }} | A+plus
@stop

@section('main_content')

			<div class="col-md-12">
			 @if($data['tag']['add_result']->added_tag)
			 	<p style="color:red;">タグが追加されました。</p>
			 @endif
			 @if($data['tag']['add_result']->deleted_tag)
			 	<p style="color:red;">タグが削除されました。</p>
			 @endif

			<div style="margin: 0 auto 20px;">

				<!-- タイトル -->
				<div class="alert a-is-info" style="margin: 0 auto 5px;">
				 <p style="font-size: 1.75em;"><?php echo $data['detail']->class_name?></p>
				</div>

				<!-- タグ作ってる -->
				<div id="tag-list" style="padding: 10px;">
			 	@if($data['tag']['list'])
				 		@foreach($data['tag']['list'] as $t)
				 		<span class="btn-label info">
				 				<input class="delete-tag-button" type="submit" value="×" style="color: black;">
				 				<a href="" style="color: white; font-size: 1.5em;">#{{ $t->tag_name }}</a>
			 			</span>
				 		@endforeach
			 	@endif
			 	</div>

			 	<!-- タグの追加 -->
			 	<div class="add_tag">
			 		<table style="width: 100%; text-align: center; background: none;">
			 			<tr><td>
					 		<a href="/tag/add/{{ $data['detail']->class_id }}" style="color: white;"><button class="btn btn-pill btn-info-outline">リストからタグを追加</button></a>&nbsp;
				 		</td><td>
					 		<button class="btn btn-pill btn-info-outline" id="add-new-tag">新しくタグを追加</button>
			 			</td></tr>
			 		</table>
			 		<div class="new-tag-field" style="width: 100%;">
			 			<input class="form-element col8" type="text" size="32" placeholder="ここに新しいタグを入力!" required id="add-tag-filed" value=""/>&nbsp;
			 			<input type="hidden" name="_token" value="{{csrf_token()}}" />
			 			<button class="btn btn-default col3" type="submit" id="add-tag-button">追加</button>
			 		</div>
			 	</div>

			 	<div class="tab-index">
			 		<ul>
			 			<li class="active"><a href="#tab1">基本情報</a></li>
			 			<li><a href="#tab2">評価</a></li>
			 			<li><a href="#tab3">レビュー</a></li>
			 		</ul>
			 	</div>
			 	<div id="tab1" class="tab-contents active">
					<!-- 基本情報 -->
					<table class="table table-bordered" style="margin: 20px auto;">
					  <thead>
					    <tr>
					      <th>担当講師</th>
					      <th>学期</th>
					      <th>曜日</th>
					      <th>時限</th>
					      <th>教室</th>
					    </tr>
					  </thead>
				    <tbody>
				      <tr>
				        <td>
				        	@if($data['teacher'])
				        		@foreach($data['teacher'] as $teacher)
				        			<a href="/search?q={{ urldecode($teacher->teacher_name) }}&day=0&period=0&term=2&_token={{csrf_token()}}">{{ $teacher->teacher_name }}</a>
				        		@endforeach
				        	@endif
				        </th>
				        <td><?php echo $data['detail']->term == 0? '春学期':'秋学期'?></td>
				        <td><?php echo $data['detail']->class_week?></td>
				        <td><?php echo $data['detail']->class_period?>限</td>
				        <td>{{ $data['detail']->room_name }}</td>
				      </tr>
				    </tbody>
					</table>
					<!-- 成績評価方法 -->
					<div style="overflow:auto;">
						<div class="col6" >
								<h3>円グラフ</h3><hr>
								<svg id="eval_pie"></svg>
						</div>
						<div class="col6" >
								<h3>棒グラフ</h3><hr>
								<div id="eval_bar">
								</div>
						</div>						
					</div>
				 	<!-- 授業要旨 -->
					@if($data['detail']->summary)
					<div class="panel panel-info" style="margin: 20px auto;">
					 <div class="panel-title">
					   授業要旨
					 </div>
					 <div class="panel-body">
					 	{{ $data['detail']->summary }}
					 </div>
					</div>
					@endif
				 	<!-- 授業レピュー -->
				 	@if(!$data['wrote_review'])
				 	<a href="/classes/review/{{ $data['detail']->class_id }}"><button class="btn btn-primary">この授業をレビューする！</button></a>
				 	@endif
				 	<a href="{{ $data['actual_syllabus_url'] }}" target="_blank"><button class="btn btn-info">公式シラバスを見る</button></a>
			 	</div>

				@if(!$data['review']->count())
				<div id="tab2" class="tab-contents">
					<div class="alert a-is-danger alert-removed fade in" style="margin: 20px auto;">
						この授業はまだレビューされていません。
					</div>
					<a href="/classes/review/{{ $data['detail']->class_id }}"><button class="btn btn-primary">この授業をレビューする！</button></a>
				</div>
				<div id="tab3" class="tab-contents">
					<div class="alert a-is-danger alert-removed fade in" style="margin: 20px auto;">
						この授業はまだレビューされていません。
					</div>
					<a href="/classes/review/{{ $data['detail']->class_id }}"><button class="btn btn-primary">この授業をレビューする！</button></a>
				</div>
				@else
				<div id="tab2" class="tab-contents">

					<table class="table table-bordered" style="margin: 20px auto; text-align: center;">
					  <thead>
					    <tr>
					      <th>総合評価度(平均)</th>
					      <th>単位の取りやすさ(平均)</th>
					      <th>GP(成績)の取りやすさ(平均)</th>
					    </tr>
					  </thead>
				    <tbody>
				      <tr>
				        <td id="raty_stars_average"></td>
				        <td id="raty_credit_average"></td>
				        <td id="raty_grade_average"></td>
				      </tr>
				    </tbody>
					</table>

					<div class="pie_graph">
							<h3>最終評価法</h3><hr>
							<svg id="evaluation_pie"></svg>
					</div>
					<div class="bar_graph">
						<h3>平常点評価</h3><hr>
						<h4>出席</h4>
					</div>
					@if(!$data['wrote_review'])
					<a href="/classes/review/{{ $data['detail']->class_id }}"><button class="btn btn-primary">この授業をレビューする！</button></a>
					@endif
				</div>

				<div id="tab3" class="tab-contents">
					<table class="table table-bordered" style="margin: 20px auto;">
						<thead>
							<tr>
							<th>投稿者</th>
<!-- 							<th>総合評価度</th> -->
							<th>レビュー</th>
							</tr>
						</thead>
						<tbody>
			      @foreach($data['review'] as $r)
			    	<tr>
			    		<td>
			    			<img src="{{ isset($r->users()->first()->avatar)? $r->users()->first()->avatar:asset('/image/dummy.png') }}" width="70"height="70"><br />
			    			{{ isset($r->users()->first()->name)? $r->users()->first()->name:"不明なユーザ" }}
			    		</td>
<!-- 		         	<td>{{{ $r->stars }}}</td> -->
		         	<td>{{{ $r->review_comment }}}</td>
		 				</tr>
			      @endforeach
						</tbody>
					</table>
					@if(!$data['wrote_review'])
					<a href="/classes/review/{{ $data['detail']->class_id }}"><button class="btn btn-primary">この授業をレビューする！</button></a>
					@endif
				</div>
				@endif
			</div>
		</div>
		<a href="/search"><button class="btn btn-sm btn-default" style="margin-bottom: 20px;">検索結果に戻る</button></a>
@stop

@section('js')
	<script type="text/javascript" src="{{ asset('/js/d3.js') }}"></script>
	@if($data['review']->count())
		<!--円グラフ用JS-->
		<script type="text/javascript" src="{{ asset('/js/evaluation_pie.js') }}"></script>
		<script type="text/javascript" src="{{ asset('/js/bar_graph.js') }}"></script>
		<script type="text/javascript">
		//グラフデータ
			var attendance_data = <?php echo $data['attendance_pie']; ?>,
				final_evaluation_data = <?php echo $data['final_evaluation_pie']; ?>,
				test_data = [{"legend":"レポート","value":70,"color":"#e74c3c"},{"legend":"試験","value":10,"color":"#16a085"},{"legend":"平常点評価","value":20,"color":"#2c3e50"}];

			var e = new pieClass("#evaluation_pie");
			//テスト用
			var w = new pieClass("#eval_pie");
			var b = new barClass("#eval_bar",test_data);

			var eval_flag = final_evaluation_data[0]["value"];
			//初回読み込み
			b.barGraph();

		    w.render(test_data);
		    w.update();
		    w.animate(test_data); 

			// 初期化
			//タブ変更してからレンダー
			$('.tab-index a').click(function(){
			  if($(this).attr("href") == "#tab2"){
			  	if(eval_flag){
			  		//タブ2で動くグラフ
				    e.render(final_evaluation_data);
				    e.update();
				    e.animate(final_evaluation_data); 
			  	}
			  	
			  }
			  b.tab_changed();
			});
			//e.update();
			// ウィンドウのリサイズイベントにハンドラを設定
			if(eval_flag){
				e.win.on("resize", e.update()); 	
			}
			
		</script>
		<!--<script type="text/javascript" src="{{ asset('/js/attendance_pie.js') }}"></script> -->
	@endif
	

	</script>
	<script type="text/javascript">
		var class_id = <?php echo $data['detail']->class_id; ?>;
	</script>
	<script type="text/javascript" src="{{ asset('/raty_lib/jquery.raty.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/js/classes.js') }}"></script>
@stop
