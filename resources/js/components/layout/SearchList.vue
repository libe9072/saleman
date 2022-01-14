/**
 * Sample.vue
 * @author libe90
 * @date   2019-12-10
 * @comment 컴포넌트 모음
 */
<template>
	<v-card>
		<v-form>
			<v-row no-gutter class="pa-2">
				<v-col cols="12">
					<v-row no-gutters>
						<v-col class="text-center font-weight-bold display-2">
							모비셀 기간 보상</v-col
						>
						<v-col cols="auto text-right">
							<v-row no-gutters>
								<v-col cols="12">
									{{ $store.state.sessionData.SNAME }} ({{
										$store.state.sessionData.SADMIN === "Y"
											? "관리자"
											: $store.state.sessionData.SUCP +
											  "M"
									}})
								</v-col>
								<v-col>
									<v-btn
										small
										color="gry"
										dark
										class="mr-1"
										@click="showPasswordChangeLayer = true"
										>비밀번호 변경</v-btn
									>
									<v-btn
										small
										color="info"
										v-if="
											$store.state.sessionData.SADMIN ===
											'Y'
										"
										@click="
											showMemberManagementLayer = true
										"
										>담당자 관리</v-btn
									>
								</v-col>
							</v-row>
						</v-col>
					</v-row>
				</v-col>
				<v-col>
					<v-row no-gutters>
						<v-col class="mr-3">
							<v-text-field
								placeholder="매장명, 모비셀 아이디, 모비고 아이디, 주소, 연락처"
								label="검색어"
								single-line
								v-model="sm_name"
								hide-details
							>
							</v-text-field>
						</v-col>
						<v-col cols="auto">
							<v-btn color="secondary" height="100%">검색</v-btn>
							<v-btn color="accent" height="100%">
								결과내 재검색</v-btn
							>
						</v-col>
					</v-row>
				</v-col>
				<v-col cols="12" class="caption error--text">
					결과가 없습니다.
				</v-col>
				<v-col cols="12">
					<v-row no-gutters class="caption">
						<v-col
							>검색어 :
							<v-chip
								class="ml-1 mb-1"
								small
								close
								label
								close-icon="mdi-close"
								>모바일</v-chip
							>
							<v-chip
								class="ml-1 mb-1"
								small
								close
								label
								close-icon="mdi-close"
								>apple</v-chip
							>
							<v-chip
								class="ml-1 mb-1"
								small
								close
								label
								close-icon="mdi-close"
								>4555</v-chip
							>
							<v-chip
								class="ml-1 mb-1"
								small
								close
								label
								close-icon="mdi-close"
								>서울빌딩</v-chip
							>
							<v-chip
								class="ml-1"
								small
								close
								label
								close-icon="mdi-close"
								>747762</v-chip
							>
						</v-col>
						<v-col cols="auto"> 검색결과 : 총 78개 </v-col>
						<v-col cols="12">
							<v-row no-gutters>
								<v-col cols="auto" class="ml-2">No</v-col>
								<v-col class="text-center">info</v-col>
							</v-row></v-col
						>
						<v-col cols="12"> <v-divider></v-divider></v-col>
						<v-col cols="12">
							<v-card class="my-1" v-for="x in 5" :key="x">
								<v-hover>
									<v-row
										no-gutters
										slot-scope="{ hover }"
										:class="`${
											hover ? 'class1' : 'class2'
										}`"
									>
										<v-col
											align-self="center"
											cols="auto"
											class="mx-2 body-2"
										>
											78
										</v-col>
										<v-col>
											<span class="font-weight-bold">
												주식회사 애플<span
													class="error--text"
													>모바일</span
												>
												/ bsc562<span
													class="error--text"
													>apple</span
												> </span
											><br />
											2022/01/22 (D-56), 2021/09/08
											(+3M)<br />
											KT000<span class="error--text"
												>747762</span
											>, B2B, GON, LIVE, LIMIT 2022/11/30,
											2021/12/31(D-84)<br />
											경기 안산시 단원구 광장23로 32,
											<span class="error--text"
												>서울빌딩</span
											>
											103
											<v-btn
												class="ml-1 align-baseline"
												outlined
												color="gry"
												x-small
												>주소복사</v-btn
											>
											<v-btn
												class="ml-1 align-baseline"
												outlined
												color="gry"
												x-small
												@click="
													MapOpen(
														'경기 안산시 단원구 광장23로 32,서울빌딩'
													)
												"
												>지도보기</v-btn
											><br />
											010-2345-6789, 031-223-<span
												class="error--text"
												>4555</span
											><br />
										</v-col>
										<v-col cols="auto" class="pa-1">
											<v-btn
												height="100%"
												color="secondary"
												@click="
													showBosangLayer001 = true
												"
											>
												기간보상
											</v-btn>
										</v-col>
									</v-row>
								</v-hover>
							</v-card>
						</v-col>
					</v-row>
				</v-col>
			</v-row>
			<PasswordChangeLayer
				:showPasswordChangeLayer.sync="showPasswordChangeLayer"
				@snackData="setSnackData"
			/>
			<BosangLayer001 :showBosangLayer001.sync="showBosangLayer001" />
			<BosangLayer002 :showBosangLayer002.sync="showBosangLayer002" />
			<MemberManagementLayer
				:showMemberManagementLayer.sync="showMemberManagementLayer"
				@snackData="setSnackData"
			/>
			<SnackBar
				:visible="showSnackBar"
				:sid="snackData"
				@close="showSnackBar = false"
			/>
		</v-form>
	</v-card>
</template>
<script>
import axios from "axios";
import PasswordChangeLayer from "../layer/PasswordChangeLayer";
import BosangLayer001 from "../layer/BosangLayer001";
import BosangLayer002 from "../layer/BosangLayer002";
import MemberManagementLayer from "../layer/MemberManagementLayer";
import { commonFunction } from "../mixins/commonFunction";
import SnackBar from "../common/SnackBar";
export default {
	components: {
		PasswordChangeLayer,
		BosangLayer001,
		BosangLayer002,
		MemberManagementLayer,
		SnackBar,
	},
	data: () => ({
		showSnackBar: false,
		snackData: "",
		showPasswordChangeLayer: false, //첨부이미지 보기 레이어
		showBosangLayer001: false, //첨부이미지 보기 레이어
		showBosangLayer002: false, //첨부이미지 보기 레이어
		showMemberManagementLayer: false, //첨부이미지 보기 레이어
	}),
	methods: {
		MapOpen(val) {
			let vals = encodeURIComponent(val);
			window.open(
				"https://map.naver.com/v5/search/" + vals,
				"window팝업"
			);
		},
		setSnackData: function (data) {
			//스낵바 부모액션
			this.snackData = data;
			this.showSnackBar = true;
		},
	},
	watch: {},
	created() {},
	mounted() {},
	computed: {},
	mixins: [commonFunction],
};
</script>
<style scoped>
.class1 {
	background-color: rgb(223, 223, 223);
}

.class2 {
}
</style>