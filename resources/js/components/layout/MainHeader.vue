/**
 * Sample.vue
 * @author libe90
 * @date   2019-12-10
 * @comment 컴포넌트 모음
 */
<template>
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
							: $store.state.sessionData.SUCP + "M"
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
						v-if="$store.state.sessionData.SADMIN === 'Y'"
						@click="showMemberManagementLayer = true"
						>담당자 관리</v-btn
					>
				</v-col>
			</v-row>
		</v-col>
		<PasswordChangeLayer
			:showPasswordChangeLayer.sync="showPasswordChangeLayer"
			@snackData="setSnackData"
		/>
		<MemberManagementLayer
			:showMemberManagementLayer.sync="showMemberManagementLayer"
			@snackData="setSnackData"
		/>
		<SnackBar
			:visible="showSnackBar"
			:sid="snackData"
			@close="showSnackBar = false"
		/>
	</v-row>
</template>
<script>
import PasswordChangeLayer from "../layer/PasswordChangeLayer";
import MemberManagementLayer from "../layer/MemberManagementLayer";
import { commonFunction } from "../mixins/commonFunction";
import SnackBar from "../common/SnackBar";
export default {
	components: {
		PasswordChangeLayer,
		MemberManagementLayer,
		SnackBar,
	},
	data: () => ({
		showSnackBar: false,
		snackData: "",
		showPasswordChangeLayer: false, //첨부이미지 보기 레이어
		showMemberManagementLayer: false, //첨부이미지 보기 레이어
	}),
	methods: {
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