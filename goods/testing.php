class Album {
		function index(){
			$album=D("album");
			$this->mess('提示：删除相册时只能删除空相册，如果相册下有子相册或有图片，请先删除子分类和图片. ');
			$this->assign("list", $album->parsetree());
			$this->display();
		}

		function add(){
			$album=D("album");
			$this->mess('提示: 带<span class="red_font">*</span>的项目为必填信息. ');
			$this->assign("select", $album->formselect());
			$this->display();
		}
phdddddddddf



phphkkkkkkkkkkkkk



gggggggggggggggggggggggggggg
