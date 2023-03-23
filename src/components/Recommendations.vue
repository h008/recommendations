<!--
  - @copyright 2019 Christoph Wurst <christoph@winzerhof-wurst.at>
  -
  - @author 2019 Christoph Wurst <christoph@winzerhof-wurst.at>
  -
  - @license GNU AGPL version 3 or any later version
  -
  - This program is free software: you can redistribute it and/or modify
  - it under the terms of the GNU Affero General Public License as
  - published by the Free Software Foundation, either version 3 of the
  - License, or (at your option) any later version.
  -
  - This program is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU Affero General Public License for more details.
  -
  - You should have received a copy of the GNU Affero General Public License?
  - along with this program.  If not, see <http://www.gnu.org/licenses/>.
  -->

<template>
	<div v-if="!loading && enabled">
		<div v-if="mode==='category' && !hidden">
			<!--

		<div>FOLDER</div>
		<div class="c3g__categories_grid">
			<div class="card__wrapper" v-for="category of categoryInfo">
				<a :href="`?fileid=`+category.id" >
					<div class="card__outline">
						<div class="card__tagname">
						 {{ category.name }}
						</div>
					</div>
				</a>
				<button @click="goCategoryFolder(category.id)">click</button>
			</div>
		</div>
		<div>TAG</div>
			-->
		<div class="c3g__categories_grid">
			<div class="card__wrapper" v-for="tag,index of tags">
				<a :href="`?dir=${tag.id}&view=systemtagsfilter`" >
					<div class="card__outline" :style="`background-color: ${colors[index%14]} ;`">
						<div class="card__tagname">
						 {{ tag.name }}
						</div>
					</div>
				</a>
			</div>
			<div class="card__wrapper">
				
					<div class="card__outline" @click="showRoot">
						<div class="card__tagname">
						 ファイルを表示
						</div>
					</div>
			
			</div>
		</div>
		</div>
		<div v-else
			id="recommendations"
			class="group">
		<button @click="showCategory">カテゴリーを表示</button>
			<RecommendedFile v-for="file in recommendedFiles"
				:id="file.id"
				:key="file.id"
				:extension="file.extension"
				:mime-type="file.mimeType"
				:name="file.name"
				:directory="file.directory"
				:reason="file.reason"
				:has-preview="file.hasPreview" />
		</div>
	</div>
</template>

<script>
import RecommendedFile from './RecommendedFile'
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'
import {Card} from '@nextcloud/vue'

export default {
	name: 'Recommendations',
	components: { RecommendedFile,Card },
	data() {
		return {
			hidden: false,
			userId: "",
			categoryInfo:null,
			tags:[],
			categoryFolderName:'.c3g_categories',
			mode:"category",
			colors:[
			"#FFADAD",
			"#FFD6A5",
			"#FDFFB6",
			"#CAFFBF",
			"#9BF6FF",
			"#A0C4FF",
			"#BDB2FF",
			"#FFC6FF",	
			"#F6CCD5","#C1C1DE","#C7DAEB","#D1E6D6","#F2EFD5","#F0E0D1"]
		}
	},
	computed: {
		enabled() {
			return this.$store.state.enabled
		},
		loading() {
			return this.$store.state.loading
		},
		recommendedFiles() {
			return this.$store.state.recommendedFiles||[]
		},
		isFolderView(){
			const search=location.search
			const fileId= search.split("fileid=")[1]
			if(!this.categoryInfo||!fileId){
				return false
			}
			const cat=this.categoryInfo.find((cat)=>cat.id===Number(fileId))
			const result= !!cat
			return result
		}
	},
	watch:{
		isFolderView(v){
			const display=v?"block":"none"
			this.changeFilesTableDisplay(display)
		},
		recommendedFiles(v){
			console.info('rec',v?.length)

		}
	},
	mounted(){
		this.fetchCategories()
		this.changeFilesTableDisplay("none")
	},	
	methods: {
		show() {
			this.hidden = false
		},
		hide() {
			this.hidden = false
		},
		async fetchCategories() {
			const url=generateUrl('/apps/recommendations/api/categories')
			const resp= await axios(url).catch((e)=>console.info(e))
			this.categoryInfo=resp?.data?.categories||[]
			this.tags=resp?.data?.tags||[]

		},
		goCategoryFolder(id){
			location.href=`?fileid=${id}`

		},
		changeFilesTableDisplay(display){
			const area=window.document.getElementById("filestable")
			if(area){
				area.style.display=display
			}
			
		},
		showRoot(){
			this.hidden=true
			this.mode="folder"
			this.changeFilesTableDisplay("block")
			
		},
		showCategory(){
			this.hidden=false
			this.mode="category"
			this.changeFilesTableDisplay("none")
		}
			
	}, 
}
</script>

<style >
	#recommendations {
		padding: 28px 30px 0 50px;
		margin-bottom: 20px;
		display: flex;
		height: 82px;
		overflow: hidden;
		flex-wrap: wrap;
		min-width: 0;
	}
	
	.c3g__categories_grid {
		width:100%;
		display: grid;
		grid-template-columns: repeat(4, 1fr);
	}

.card__wrapper{
	margin:8px;
}

.card__wrapper:hover{
	transform: translateY(-5px);
	box-shadow:0 7px 34px rgba(50,50,93,.1),0 3px 6px rgba(0,0,0,.8);
	transition:all .5s;
}
.card__outline{
	height:100%;
	background:#fff;
	border-radius:5px;
	box-shadow:0 2px 5px #ccc;
	position:relative;
	display:flex;
	justify-content: center;
	align-items: center;
	padding-block: 4em;
}

.card__tagname{
	font-weight: bolder;
	font-size: xx-large;
}

	/* show 2 per line for screen sizes smaller that 1200px */
	@media only screen and (max-width: 1200px) {
		#recommendations {
			height: initial;
			max-height: 189px;
		}
	.c3g__categories_grid {
		width:100%;
		display: grid;
		grid-template-columns: repeat(2, 1fr);
	}

	}
</style>
