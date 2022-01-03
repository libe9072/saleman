/**
 * commonModal.js
 * @author libe90
 * @date   2019-12-09
 * @date   2020-03-20 sukjada : 취소 버튼 누를 경우 진행되는 cancelAction 추가
 * @comment 모달창 관련 공통 펑션
 */
export const commonModal = {
  props: ['visible', 'props'],
  computed: {
    show: {
      get () {
        return this.visible
      },
      set (value) {
        if (!value) {
          this.$emit('close') //기본모달창 닫기
          this.$emit('closed')  //풀화면용 닫기
        }
      }
    }
  },
  methods: {
    okAction: function (data) { //컨펌모달 OK액션용
      this.$emit('confirmAction', this.props.okAction)
      this.show = false
    },
    cancelAction: function (data) { //컨펌모달 cancel액션용
      this.$emit('close', this.props.cancelAction)
      this.show = false
    }
  }
}
