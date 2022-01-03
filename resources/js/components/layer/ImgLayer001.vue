/**
 * ImgLayer001.vue
 * @author libe90
 * @date 2020-11-25
 * @comment 첨부사진보기 공통창 
*/
<template>
	<div>
		<ModalLayer
			:visible="showFullModal"
			@closed="showFullModal = false"
			:topProps="topProps"
			@nextClick="nextClick"
		>
			<template v-slot:viewContent>
				<v-container>
					<!-- 첨부이미지 -->
					<v-card class="pa-2">
						<v-img
							class="ma-auto"
							max-width="600"
							:src="`/storage/${imgData.imgSrc}`"
						></v-img>
					</v-card>
					<v-card class="pa-4 mt-3">
						<v-row no-gutters class="caption">
							<v-col
								cols="12"
								class="caption mb-1 font-weight-bold"
							>
								첨부 사진 상세 정보
							</v-col>
							<v-col
								cols="2"
								class="py-1 px-2 blue-grey--text lighten-5"
								style="
									border-top: 1px solid #d4d9e1;
									border-right: 1px solid #d4d9e1;
								"
							>
								파일이름
							</v-col>
							<v-col
								cols="10"
								class="py-1 px-2"
								style="border-top: 1px solid #d4d9e1"
							>
								{{ imgData.name }}
							</v-col>
							<v-col
								cols="2"
								class="py-1 px-2 blue-grey--text lighten-5"
								style="
									border-top: 1px solid #d4d9e1;
									border-right: 1px solid #d4d9e1;
								"
							>
								첨부일시
							</v-col>
							<v-col
								cols="10"
								class="py-1 px-2"
								style="border-top: 1px solid #d4d9e1"
							>
								{{ imgData.reg_date }}
							</v-col>
							<v-col
								cols="2"
								class="py-1 px-2 blue-grey--text lighten-5"
								style="
									border-top: 1px solid #d4d9e1;
									border-bottom: 1px solid #d4d9e1;
									border-right: 1px solid #d4d9e1;
								"
							>
								사용자 ID
							</v-col>
							<v-col
								cols="10"
								class="py-1 px-2"
								style="
									border-top: 1px solid #d4d9e1;
									border-bottom: 1px solid #d4d9e1;
								"
							>
								{{ imgData.reg_id }}
							</v-col>
						</v-row>
					</v-card>
				</v-container>
			</template>
		</ModalLayer>
	</div>
</template>

<script>
import ModalLayer from "../layout/ModalLayer";
import dataProps from "../../assets/dataProps";
import { commonFunction } from "../mixins/commonFunction";
export default {
	name: "ImgLayer001",
	components: {
		ModalLayer,
	},
	props: {
		showImgLayer001: {
			default: false,
		},
		imgData: {
			// 조건
			default: [],
		},
	},
	computed: {
		showFullModal: {
			get() {
				if (this.showImgLayer001 === true) {
				}
				return this.showImgLayer001;
			},
			set(value) {
				this.$emit("update:showImgLayer001", value);
			},
		},
	},
	data: () => ({
		topProps: dataProps.fullModal.ImgLayer001,
	}),
	methods: {},
	created() {},
	watch: {},
	mixins: [commonFunction],
};
</script>
