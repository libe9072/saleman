/**
 * Sample.vue
 * @author libe90
 * @date   2019-12-10
 * @comment 컴포넌트 모음
 */
<template>
	<v-form>
		<v-row no-gutter class="pa-2">
			<v-col cols="12" class="text-center font-weight-bold display-2">
				모비셀 기간 보상
			</v-col>
			<v-col>
				<v-row no-gutters>
					<v-col class="mr-3">
						<v-text-field
							placeholder="이름"
							label="이름"
							v-model="sm_name"
							hide-details
							@keyup.enter="loginSaleman"
						>
						</v-text-field>
						<v-text-field
							placeholder="전화번호"
							label="전화번호"
							v-model="sm_phone"
							hide-details
							maxLength="13"
							type="tel"
							@keyup="phoneKeyup"
							@keyup.enter="loginSaleman"
						>
						</v-text-field>
						<v-text-field
							placeholder="비밀번호"
							label="비밀번호"
							v-model="sm_pw"
							type="password"
							hide-details
							@keyup.enter="loginSaleman"
						>
						</v-text-field>
					</v-col>
					<v-col cols="3">
						<v-btn
							color="secondary"
							height="100%"
							block
							@click="loginSaleman"
						>
							로그인</v-btn
						>
					</v-col>
				</v-row>
			</v-col>
			<v-col cols="12" class="caption error--text" v-if="msg">
				* {{ msg }}
			</v-col>
		</v-row>
	</v-form>
</template>
<script>
import axios from "axios";
import { Auth } from "../../api";
export default {
	data: () => ({
		sm_name: null,
		sm_phone: null,
		sm_pw: null,
		msg: null,
	}),
	methods: {
		loginSaleman() {
			axios
				.post("/api/saleman/loginSaleman?_method=PUT", {
					_token: this.csrfToken,
					sm_name: this.sm_name,
					sm_phone: this.sm_phone,
					sm_pw: this.sm_pw,
					params: { type: "mod" },
				})
				.then(({ data }) => {
					if (data.message) {
						this.msg = data.message;
					} else {
						localStorage.saveName = this.sm_name;
						localStorage.savePhone = this.sm_phone;
						localStorage.savePw = this.sm_pw;

						Auth.login(data).then(() =>
							this.$router.push(this.$route.query.redirect || "/")
						);
					}
				});
		},
		phoneKeyup() {
			if (this.sm_phone.length === 3) {
				this.sm_phone += "-";
			}
			if (this.sm_phone.length === 8) {
				this.sm_phone += "-";
			}
		},
	},
	watch: {},
	created() {
		if (typeof localStorage.saveName !== undefined) {
			this.sm_name = localStorage.saveName;
			this.sm_phone = localStorage.savePhone;
			this.sm_pw = localStorage.savePw;
		}
	},
	mounted() {},
	computed: {},
};
</script>