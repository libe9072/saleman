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
			@nextClick="submitAction"
		>
			<template v-slot:viewContent>
				<v-container>
					<v-form v-model="valid" ref="form">
						<!-- 첨부이미지 -->
						<v-card class="pa-2">
							<v-text-field
								placeholder="기존 비밀번호"
								label="기존 비밀번호"
								v-model="sm_pw"
								:append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
								:type="show1 ? 'text' : 'password'"
								@click:append="show1 = !show1"
								:rules="[
									rules.required,
									rules.checkPass(sm_pw, checkedLastPassword),
								]"
								@blur="checkPassWord"
							>
							</v-text-field>
							<v-text-field
								placeholder="신규 비밀번호"
								label="신규 비밀번호"
								v-model="new_pw"
								:append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
								:type="show2 ? 'text' : 'password'"
								:rules="[rules.min(new_pw)]"
								@click:append="show2 = !show2"
							>
							</v-text-field>
							<v-text-field
								placeholder="비밀번호 확인"
								label="비밀번호 확인"
								v-model="confirm_pw"
								:append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
								:type="show3 ? 'text' : 'password'"
								:rules="[
									rules.min(new_pw),
									rules.match(confirm_pw, new_pw),
								]"
								@click:append="show3 = !show3"
							>
							</v-text-field>
						</v-card>
					</v-form>
				</v-container>
			</template>
		</ModalLayer>
	</div>
</template>

<script>
import ModalLayer from "../layout/ModalLayer";
import dataProps from "../../assets/dataProps";
import axios from "axios";
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
		sm_pw: null,
		new_pw: null,
		confirm_pw: null,
		show1: false,
		show2: false,
		show3: false,
		rules: {
			required: (value) => !!value || "필수값입니다.",
			min: function min(data) {
				//현재 비밀번호 입력값 맞는지 확인 용
				if (data && typeof data !== "undefined") {
					return (
						data.length > 3 ||
						"변경 비밀번호를 4자리 이상 입력하시기 바랍니다."
					);
				}
				return true;
			},
			checkPass: function checkPass(data, last_pass) {
				//현재 비밀번호 입력값 맞는지 확인 용
				if (data && typeof data !== "undefined") {
					return last_pass === true || "현재 비밀번호를 확인하세요.";
				}
				return true;
			},
			match: function match(data, password) {
				// 변경할 비밀번호와 변경확인용 비밀번호 체크
				if (password && typeof password !== "undefined") {
					return data === password || "변경 비밀번호를 확인하세요.";
				}
				return true;
			},
		},
		checkedLastPassword: false, // 현재 비밀번호 입력값 맞는지 확인 용
	}),
	methods: {
		checkPassWord() {
			// 현재 비밀번호 확인
			if (this.sm_pw) {
				axios
					.post("/api/saleman/checkCurrentPassword?_method=PUT", {
						_token: this.csrfToken,
						sm_pw: this.sm_pw,
						params: { type: "mod" },
					})
					.then(({ data }) => {
						this.checkedLastPassword =
							data.code === 1 ? true : false;
					});
			}
		},
		submitAction() {
			this.validate();
			if (this.valid === true) {
				axios
					.post("/api/saleman/changePassword?_method=PUT", {
						_token: this.csrfToken,
						new_pw: this.new_pw,
						params: { type: "mod" },
					})
					.then(({ data }) => {
						localStorage.savePw = this.new_pw;
						this.$emit(
							"snackData",
							this.makeSnakeData(
								"비밀번호 변경이 완료되었습니다.",
								"success"
							)
						);
						this.resetPasswordData();
						this.checkedLastPassword = false;
						this.$emit("update:showPasswordChangeLayer", false);
					});
			}
		},
		// 입력한 비밀번호들 초기화
		resetPasswordData() {
			this.sm_pw = null;
			this.new_pw = null;
			this.confirm_pw = null;
		},
	},
	created() {},
	watch: {},
	mixins: [commonFunction],
};
</script>
