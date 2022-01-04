/**
 * PasswordChangeLayer.vue
 * @author libe90
 * @date 2021-01-03
 * @comment 비밀번호 변경 
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
						<v-text-field
							placeholder="기존 비밀번호"
							label="기존 비밀번호"
							v-model="sm_password"
							type="password"
						>
						</v-text-field>
						<v-text-field
							placeholder="신규 비밀번호"
							label="신규 비밀번호"
							v-model="sm_password2"
							type="password"
						>
						</v-text-field>
						<v-text-field
							placeholder="비밀번호 확인"
							label="비밀번호 확인"
							v-model="sm_passwor3"
							type="password"
						>
						</v-text-field>
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
	name: "PasswordChangeLayer",
	components: {
		ModalLayer,
	},
	props: {
		showPasswordChangeLayer: {
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
				if (this.showPasswordChangeLayer === true) {
				}
				return this.showPasswordChangeLayer;
			},
			set(value) {
				this.$emit("update:showPasswordChangeLayer", value);
			},
		},
	},
	data: () => ({
		topProps: dataProps.fullModal.PasswordChangeLayer,
	}),
	methods: {},
	created() {},
	watch: {},
	mixins: [commonFunction],
};
</script>
