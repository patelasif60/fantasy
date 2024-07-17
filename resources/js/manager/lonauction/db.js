import firebase from 'firebase'

export const db = firebase
  .initializeApp({ projectId: 'fantasy-league-new' })
  .firestore()

// Export types that exists in Firestore
// export { TimeStamp, GeoPoint } = firebase.firestore

// if using Firebase JS SDK < 5.8.0
db.settings({ timestampsInSnapshots: true })